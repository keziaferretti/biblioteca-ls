<?php

namespace App\Concerns;

use Illuminate\Support\Str;

trait CamelCasing
{
    public function getAttribute($key)
    {
        return parent::getAttribute($this->toSnake($key));
    }

    public function setAttribute($key, $value)
    {
        return parent::setAttribute($this->toSnake($key), $value);
    }

    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();
        $result     = [];

        foreach ($attributes as $key => $value) {
            $result[Str::camel($key)] = $value;
        }

        return $result;
    }

    public function relationsToArray()
    {
        $relations = parent::relationsToArray();
        $result    = [];

        foreach ($relations as $key => $value) {
            $result[Str::camel($key)] = $value;
        }

        return $result;
    }

    protected function toSnake(string $key): string
    {
        return Str::snake($key);
    }
}
