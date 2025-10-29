<?php

namespace MemoGram\Handle\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;

trait ManagesTypes
{
    /**
     * @param class-string<Model> $model
     * @param string|array|null $key
     * @return $this
     */
    public function usingFind(string $model, null|string|array $key = null)
    {
        if ($key === null) {
            $key = (new $model)->getKeyName();
        }

        $key = array_values(Arr::wrap($key));

        $this->using(
            store: $store = function (?Model $model) use ($key) {
                if ($model === null) {
                    return null;
                }

                $keep = array_map(fn($attr) => $model->getAttribute($attr), $key);

                if (count($keep) == 1) {
                    return reset($keep);
                }

                return $keep;
            },
            restore: function (array|int|string|null $value) use ($key, $model) {
                if ($value === null) {
                    return null;
                }

                $value = Arr::wrap($value);
                $query = $model::query();

                foreach ($key as $i => $attr) {
                    $query->where($attr, $value[$i]);
                }

                return $query->firstOrFail();
            },
            dirtySerialize: function (?Model $model) use ($store) {
                return serialize($store($model));
            },
        );

        return $this->type('?' . $model);
    }

    public function usingDynamicFind()
    {
        $this->using(
            store: function (?Model $model) {
                if ($model === null) {
                    return null;
                }

                return [$model->getMorphClass(), $model->getKey()];
            },
            restore: function (array|null $value) {
                if ($value === null) {
                    return null;
                }

                [$model, $key] = $value;
                $model = Relation::getMorphedModel($model);

                return $model::query()->findOrFail($key);
            },
        );

        return $this->type('?' . Model::class);
    }
}