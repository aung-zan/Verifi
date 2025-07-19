<?php

namespace App\Repositories;

use App\Interfaces\DBInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements DBInterface
{
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function get(array $filter, array $search): Collection
    {
        $query = $this->model->query();

        // queries for filter and search.

        return $query->get();
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function getById(int $id): ?User
    {
        return $this->model->where('id', $id)
            ->firstOrFail();
    }

    public function update(int $id, array $data): ?User
    {
        $user = $this->getById($id);

        $user->update($data);

        return $user;
    }

    public function delete(int $id): void
    {
        $user = $this->getById($id);

        $user->delete();
    }
}
