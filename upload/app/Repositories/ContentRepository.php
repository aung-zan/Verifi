<?php

namespace App\Repositories;

use App\Interfaces\DBInterface;
use App\Models\Content;
use Illuminate\Database\Eloquent\Collection;

class ContentRepository implements DBInterface
{
    private $model;

    public function __construct(Content $content)
    {
        $this->model = $content;
    }

    public function get(array $filter, array $search): Collection
    {
        $query = $this->model->query();

        // queries for filter and search.
        foreach ($filter as $column => $value) {
            $query = $query->where($column, $value);
        }

        return $query->get();
    }

    public function create(array $data): Content
    {
        return $this->model->create($data);
    }

    public function getById(int $id): ?Content
    {
        return $this->model->where('id', $id)
            ->firstOrFail();
    }

    public function getWithUserId(int $id, int $userId): ?Content
    {
        return $this->model->where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    public function update(int $id, array $data): ?Content
    {
        $content = $this->getById($id);

        $content->update($data);

        return $content;
    }

    public function delete(int $id): void
    {
        $content = $this->getById($id);

        $content->delete();
    }
}
