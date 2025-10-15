<?php

namespace MemoGram\Api\Concerns;

use Illuminate\Support\Facades\Http;

trait Requests
{
    public function call(string $method, array $data = []): mixed
    {
        $data = $this->prepareData($data);

        return Http
            ::asForm()
            ->timeout(60)
            ->acceptJson()
            ->asJson()
            ->throw()
//            ->when(!empty($this->proxy))
//            ->withOptions([
//                'proxy' => $this->proxy,
//            ])
            ->post("https://api.telegram.org/bot{$this->token}/{$method}", $data)
            ->json('result');
    }

    protected function prepareData(array $data): array
    {
        $data = array_filter($data, fn($value) => $value !== null);

        foreach ($data as $key => $value) {
            if (is_object($value)) {
                $data[$key] = $this->prepareData(get_object_vars($value));
            }
        }

        return $data;
    }

    public function castValue($value, array $cast): mixed
    {
        if ($cast && $value !== null) {
            if (class_exists($cast[0])) {
                return $cast[0]::makeFromArray($value);
            } elseif ($cast[0] == 'array') {
                return collect($value)->map(fn($item) => $cast[1]::makeFromArray($item))->all();
            }
        }

        return $value;
    }
}