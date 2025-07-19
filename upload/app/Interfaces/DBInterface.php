<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface DBInterface
{
    public function get(array $filter, array $search): Collection;

    public function create(array $data): Model;

    public function getById(int $id): ?Model;

    public function update(int $id, array $data): ?Model;

    public function delete(int $id): void;
}
