<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    private $db;

    public function __construct(UserRepository $userRepository)
    {
        $this->db = $userRepository;
    }

    /**
     * Create the user.
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User
    {
        return $this->db->create($data);
    }

    /**
     * Return the specific user by id or 404.
     *
     * @param int $id
     * @return ?User
     */
    public function getUser(int $id): ?User
    {
        return $this->db->getById($id);
    }

    /**
     * Update the specific user.
     *
     * @param int $id
     * @param array $data
     * @return ?User
     */
    public function updateUser(int $id, array $data)
    {
        return $this->db->update($id, $data);
    }
}
