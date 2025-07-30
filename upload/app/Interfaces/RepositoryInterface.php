<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface extends DBInterface
{
    public function getByUserId(int $id, int $userId): ?Model;
}
