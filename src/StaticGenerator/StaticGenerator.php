<?php

namespace MemoGram\StaticGenerator;

class StaticGenerator
{
    public function generate()
    {
        $this->generateApis();
    }

    protected const CHOOSING_TYPES = [
        'MaybeInaccessibleMessage' => [
            'key' => 'date',
            'values' => [
                [0, 'InaccessibleMessage'],
                [null, 'Message'],
            ],
        ],
        'InputMedia' => [
            'key' => 'type',
            'values' => [
                ['photo', 'InputMediaPhoto'],
                ['video', 'InputMediaVideo'],
                ['animation', 'InputMediaAnimation'],
                ['audio', 'InputMediaAudio'],
                ['document', 'InputMediaDocument'],
            ],
        ],
        'InputFile' => [
            'key' => 'type',
            'values' => [
                ['photo', 'InputPaidMediaPhoto'],
                ['video', 'InputPaidMediaVideo'],
            ],
        ],
        'InputProfilePhoto' => [
            'key' => 'type',
            'values' => [
                ['static', 'InputProfilePhotoStatic'],
                ['animated', 'InputProfilePhotoAnimated'],
            ],
        ],
        'InputStoryContent' => [
            'key' => 'type',
            'values' => [
                ['photo', 'InputStoryContentPhoto'],
                ['video', 'InputStoryContentVideo'],
            ],
        ],
    ];

    protected function generateApis(): void
    {
        $CRAWLER_PROXY = null; // Set to null to disable

        // --- Step 1: Fetch HTML Content ---
        echo "Using SOCKS5 proxy: " . ($CRAWLER_PROXY ?? 'Disabled') . " for crawling.\n";
        $ch = curl_init();
        $curl_options = [
            CURLOPT_URL => 'https://core.telegram.org/bots/api',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ];
        if ($CRAWLER_PROXY) {
            $curl_options[CURLOPT_PROXY] = $CRAWLER_PROXY;
            $curl_options[CURLOPT_PROXYTYPE] = CURLPROXY_SOCKS5;
        }
        curl_setopt_array($ch, $curl_options);
        $htmlContent = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($htmlContent === false || !empty($error)) {
            die("cURL Error: Could not fetch content. Error: " . $error . "\n");
        }
        echo "Successfully fetched HTML content.\n";

        $dom = new \DOMDocument();
        @$dom->loadHTML($htmlContent);
        $xpath = new \DOMXPath($dom);

        // --- Step 2: Extract All Methods and Types ---
        $nodes = $xpath->query('//h4');
        $allTypes = [];
        $allMethods = [];
        echo "Parsing " . $nodes->length . " h4 elements...\n";
        foreach ($nodes as $node) {
            $title = trim($node->textContent);
            /** @var \DOMElement $nextElement */
            $nextElement = $node->nextElementSibling;
            while ($nextElement && $nextElement->tagName !== 'table') {
                $nextElement = $nextElement->nextElementSibling;
            }
            if (!$nextElement) continue;

            if (preg_match('/^[a-z]/', $title) && !str_contains($title, ' ')) {
                $table = $this->parseTable($xpath, $nextElement);
                $allMethods[$title] = ['name' => $title, 'parameters' => $table['items'], 'description' => $table['description'], 'returns' => $table['returns']];
            } elseif (preg_match('/^[A-Z]/', $title) && !str_contains($title, ' ')) {
                $table = $this->parseTable($xpath, $nextElement);
                $allTypes[$title] = ['name' => $title, 'fields' => $table['items']];
            }
        }
        echo "Found " . count($allTypes) . " types and " . count($allMethods) . " methods.\n";

        // --- Step 4: Generate File Contents ---
        $typesNamespace = 'MemoGram\\Api\\Types';
        $typesDir = __DIR__ . '/../Api/Types';

        // Generate Type classes
        foreach ($allTypes as $type) {
            $className = $type['name'];

            if (array_key_exists($className, self::CHOOSING_TYPES)) {
                continue;
            }

            $usedTypes = $this->getUsedTypes($type['fields']);

            $uses = "";
            foreach ($usedTypes as $usedType) {
                if ($usedType !== $className && !array_key_exists($usedType, self::CHOOSING_TYPES)) { // Don't use your own class
                    $uses .= "use {$typesNamespace}\\{$usedType};\n";
                }
            }

            $props = "";
            foreach ($type['fields'] as $field) {
                $typeHint = $this->getTypeHint($field['doc_type']);
                $attributes = $this->getAttributes($field['doc_type']);

                if (array_key_exists($field['doc_type'], self::CHOOSING_TYPES)) {
                    $docType = $typeHint;
                } else {
                    $docType = str_replace('<', '<\\' . $typesNamespace . '\\', $field['doc_type']);
                }

                $docType .= (!$field['required'] ? '|null' : '');

                $props .= "/** @var {$docType} {$field['description']} */\n";
                if ($attributes) {
                    $props .= $attributes . "\n";
                }
                if ($field['required']) {
                    $props .= "public {$typeHint} \${$field['name']},\n\n";
                } else {
                    $defaultValue = ' = null';
                    $typeHint = $typeHint == 'mixed' ? $typeHint : 'null|' . $typeHint;
                    $props .= "public {$typeHint} \${$field['name']}{$defaultValue},\n\n";
                }
            }

            $stubPath = __DIR__ . '/stubs';
            $this->write("$typesDir/$className.php", file_exists("$stubPath/type_$className.stub") ? "$stubPath/type_$className.stub" : "$stubPath/type.stub", [
                'class' => $className,
                'uses' => $uses,
                'props' => $props,
            ]);
        }

        $allUsedTypes = [];
        foreach ($allMethods as $method) {
            foreach ($this->getUsedTypes($method['parameters']) as $type) {
                $allUsedTypes[$type] = true;
            }
        }
        $allUsedTypes = array_keys($allUsedTypes);
        sort($allUsedTypes);

        $methods = "";
        foreach ($allMethods as $method) {
            $sortedParameters = collect($method['parameters'])
                ->sortBy(fn($param, $index) => [!$param['required'], $index])
                ->all();

            $returnsDoc = match ($method['returns'][0]) {
                'true', 'false', 'mixed', 'string' => $method['returns'][0],
                'array' => "array<{$method['returns'][1]}>",
                default => is_array($method['returns'][0]) ? implode('|', $method['returns'][0]) : $method['returns'][0],
            };
            $returns = str_starts_with($returnsDoc, 'array<') ? 'array' : $returnsDoc;

            if ($returnsDoc != 'mixed') $returnsDoc .= '|null';
            if ($returns != 'mixed') $returns .= '|null';

            $methods .= "/**\n";
            $methods .= " * {$method['description']}\n";
            foreach ($sortedParameters as $param) {
                $docType = str_replace('<', '<\\' . $typesNamespace . '\\', $param['doc_type']);
                $docType .= (!$param['required'] ? '|null' : '');
                $methods .= " * @param {$docType} \${$param['name']} {$param['description']}\n";
            }
            $methods .= " * @return {$returnsDoc}\n";
            $methods .= " */\n";
            $argsList = [];
            foreach ($sortedParameters as $param) {
                // Base type hint (e.g., 'int|string' or 'User')
                $typeHint = str_contains($param['doc_type'], '|') ? $param['doc_type'] : $this->getTypeHint($param['doc_type']);

                if (preg_match('/(\||\?|^)mixed(\||$)/', $typeHint)) {
                    $typeHint = 'mixed';
                }

                if ($param['required']) {
                    $paramStr = "{$typeHint} \${$param['name']}";
                } else {
                    // Optional parameter
                    $defaultValue = ' = null';

                    // Make the type hint nullable. For 'string' -> '?string'. For 'int|string' -> 'int|string|null'.
                    $nullableTypeHint = $typeHint == 'mixed' ? 'mixed' : (str_contains($typeHint, '|') ? ($typeHint . '|null') : "?{$typeHint}");

                    $paramStr = "{$nullableTypeHint} \${$param['name']}{$defaultValue}";
                }

                $argsList[] = $paramStr;
            }

            $castMap = function ($v) use (&$castMap, &$allUsedTypes) {
                if (is_array($v)) {
                    return '[' . collect($v)->map($castMap)->implode(', ') . ']';
                }

                if (ctype_upper($v[0])) {
                    if (!in_array($v, $allUsedTypes)) {
                        $allUsedTypes[] = $v;
                    }

                    return "$v::class";
                }

                return "'" . $v . "'";
            };

            $methods .= "public function " . $method['name'] . "(" . implode(', ', $argsList) . ", ...\$args): $returns\n{\n";
            $methods .= "    \$vars = get_defined_vars();\n";
            $methods .= "    unset(\$vars['args']);\n";
            $methods .= "    \$vars += \$args;\n";
            $methods .= "    return \$this->castValue(\$this->call('{$method['name']}', \$vars), {$castMap($method['returns'])});\n";
            $methods .= "}\n\n";
        }

        $uses = "";
        foreach ($allUsedTypes as $usedType) {
            $uses .= "use {$typesNamespace}\\{$usedType};\n";
        }

        $this->write(__DIR__ . "/../Api/TelegramApi.php", __DIR__ . '/stubs/telegram_api.stub', [
            'uses' => $uses,
            'methods' => $methods,
        ]);
    }

    protected function getUsedTypes(array $fields): array
    {
        $usedTypes = [];
        foreach ($fields as $field) {
            foreach (str($field['doc_type'])->explode(' or ')->map(fn($x) => explode('|', $x))->flatten() as $type) {
                if (ctype_upper($type[0])) {
                    $usedTypes[$type] = true;
                }
            }
        }
        return array_keys($usedTypes);
    }

    protected function parseTable(\DOMXPath $xpath, \DOMElement $tableNode): array
    {
        $items = [];

        for ($pNode = $tableNode->previousElementSibling; $pNode && $pNode?->previousElementSibling?->tagName != 'h4'; $pNode = $pNode?->previousElementSibling) ;
        $description = $pNode->textContent ?? "";

        if (str_contains($description, 'On success, if the message is not an inline message, the Message is returned, otherwise True is returned.')) {
            $returns = [['Message', 'true']];
        } elseif (preg_match('/Returns (.*?)\./', $description, $matches)) {
            $returns = trim($matches[1]);
            $returns = preg_replace('/ on success$/', '', $returns);

            if ($returns === 'True' || $returns === 'False') {
                $returns = [strtolower($returns)];
            } elseif (preg_match('/^an Array of (\w+) objects$/', $returns, $matches)) {
                $returns = ['array', $matches[1]];
            } elseif ($returns == 'the MessageId of the sent message' || $returns == 'the amount of Telegram Stars owned by a managed business account') {
                $returns = ['int'];
            } elseif (preg_match('/^a (\w+) object$/', $returns, $matches)) {
                $returns = [$matches[1]];
            } elseif (preg_match('/^the uploaded (\w+)$/', $returns, $matches)) {
                $returns = [$matches[1]];
            } elseif (preg_match('/ as (a |)(\w+) object$/', $returns, $matches)) {
                $returns = [$matches[2]];
            } elseif (preg_match('/ as String$/', $returns, $matches)) {
                $returns = ['string'];
            } elseif (preg_match('/^\w+$/', $returns, $matches)) {
                $returns = [$returns];
            } elseif ($returns == 'the gifts received and owned by a managed business account' || $returns == "the bot's Telegram Star transactions in chronological order") {
                // todo
                $returns = ['mixed'];
            } else {
                dd($returns);
            }
        } elseif (preg_match('/the sent (\w+) is returned./', $description, $matches)) {
            $returns = [$matches[1]];
        } else {
            $returns = ['mixed'];
        }

        $returns = array_map(function ($value) {
            if ($value === "Int") {
                return 'int';
            }

            return $value;
        }, $returns);

        $rows = $xpath->query('.//tr', $tableNode);
        foreach ($rows as $index => $row) {
            if ($index === 0) continue;
            $cols = $xpath->query('.//td', $row);
            if ($cols->length < 3) continue;
            $name = trim($cols->item(0)->textContent);
            if (str_contains($name, ' ')) continue;
            $type = trim($cols->item(1)->textContent);
            $description = trim($cols->item(2)->textContent);
            if ($cols->length > 3 && in_array(strtolower($description), ['yes', 'no', 'optional'])) {
                $description = trim($cols->item(3)->textContent);
            }

            $items[] = [
                'name' => $name,
                'doc_type' => $this->convertTypeToPhp($type),
                'required' => !str_starts_with($description, 'Optional.') && !in_array($cols->item(2)->textContent, ['Optional', 'No']),
                'description' => str_replace("\n", " ", $description),
            ];
        }

        return [
            'description' => $description,
            'returns' => $returns,
            'items' => $items,
        ];
    }

    protected function convertTypeToPhp(string $type): string
    {
        $type = trim($type);
        if (str_starts_with(strtolower($type), 'array of ')) {
            return 'array<' . $this->convertTypeToPhp(substr($type, 9)) . '>';
        }
        if (str_contains($type, ' or ')) {
            return implode('|', array_map($this->convertTypeToPhp(...), explode(' or ', $type)));
        }
        return match (strtolower($type)) {
            'integer' => 'int',
            'string' => 'string',
            'boolean', 'true', 'false' => 'bool',
            'float', 'float number' => 'float',
            'inputfile' => 'mixed',
            default => ucfirst($type),
        };
    }

    protected function getTypeHint(string $docType): string
    {
        $docTypeWithoutNull = preg_replace('/(^\?|null\|)|(\|null$)/', '', $docType, -1, $isNullable);

        if (array_key_exists($docTypeWithoutNull, self::CHOOSING_TYPES)) {
            return collect(self::CHOOSING_TYPES[$docTypeWithoutNull]['values'])->map(fn($v) => $v[1])->implode("|");
        }

        if (str_starts_with($docType, 'array<')) {
            return 'array';
        }

        return explode('|', $docType)[0];
    }

    protected function getAttributes(string $docType): string
    {
        $docType = preg_replace('/(^\?|null\|)|(\|null$)/', '', $docType);

        if (array_key_exists($docType, self::CHOOSING_TYPES)) {
            $key = self::CHOOSING_TYPES[$docType]['key'];

            return "#[\MemoGram\Api\Attributes\_Choose(\"$key\", [" .
                collect(self::CHOOSING_TYPES[$docType]['values'])->map(function ($v) use ($key) {
                    return "[" . match (true) {
                            is_string($v[0]) => "\"$v[0]\"",
                            is_int($v[0]) => $v[0],
                            is_null($v[0]) => 'null',
                        } . ", {$v[1]}::class]";
                })->implode(", ") .
                "])]";
        }

        return '';
    }


    protected function write(
        string $path,
        string $stub,
        array  $variables,
    )
    {
        $content = file_get_contents($stub);
        $indent = function (string $value, int $tabs): string {
            return str_replace("\n", "\n" . str_repeat("    ", $tabs), $value);
        };

        $content = preg_replace_callback('/\{\{(.*?)}}/', function ($_match) use ($variables, $indent) {
            foreach ($variables as $_name => $_value) {
                $$_name = $_value;
            }

            unset($_name, $_value, $variables);
            return eval("return {$_match[1]};");
        }, $content);

        file_put_contents($path, $content);

        echo "Created: {$path}\n";
    }
}