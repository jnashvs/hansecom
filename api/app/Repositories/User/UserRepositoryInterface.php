<?php

namespace App\Repositories\User;

use App\Models\User;

/**
 *
 */
interface UserRepositoryInterface
{
    /**
     * @param int $id
     * @return User|null
     */
    public function getById(int $id): ?User;

    /**
     * @param string $email
     * @return ?User
     */
    public function getByEmail(string $email): ?User;

    /**
     * @param string $name
     * @param string $email
     * @param ?string $password
     * @return User
     */
    public function create(
        string $name,
        string $email,
        ?string $password
    ): User;

    /**
     * @param User $user
     * @param string $name
     * @param string $email
     * @param ?string $password
     * @return User
     */
    public function update(
        User $user,
        string $name,
        string $email,
        ?string $password
    ): User;

    public function delete(User $user): bool;
}
