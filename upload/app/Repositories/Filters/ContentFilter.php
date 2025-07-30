<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;

class ContentFilter
{
    private $filter;

    public function __construct(array $filter)
    {
        $this->filter = $filter;
    }

    public function apply(Builder $query): Builder
    {
        foreach ($this->filter as $column => $value) {
            if (method_exists($this, $column)) {
                $this->$column($query, $value);
            }
        }

        return $query;
    }

    private function status(Builder $query, int $value): void
    {
        $query->where('status', $value);
    }

    private function type(Builder $query, int $value): void
    {
        $query->whereHas('result', function (Builder $query) use ($value) {
            $query->where('type', $value);
        });
    }
}
