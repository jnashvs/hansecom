<?php

namespace App\Models\Factories\User;

use App\Models\User;
use App\Models\Factories\AbstractFactory;
use App\Modules\Exceptions\FatalRepositoryException;
use Illuminate\Support\Facades\Hash;

/**
 *
 */
class UserFactory extends AbstractFactory
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct(User::class);
    }

    /**
     * @param string $email
     * @return bool
     */
    public function exists(string $email): bool
    {
        return User::query()->where('email', $email)->exists();
    }

    /**
     * @param string $email
     * @return ?User
     */
    public function getByEmail(string $email): ?User
    {
        return User::query()->where('email', $email)->get()->first();
    }


    /**
     * @param string $name
     * @param string $email
     * @param ?string $password
     * @return User
     * @throws FatalRepositoryException
     */
    public function create(
        string $name,
        string $email,
        ?string $password
    ): User {
        $user = new User();

        return $this->update($user, $name, $email, $password);
    }

    /**
     * @param User $user
     * @param string $name
     * @param string $email
     * @param ?string $password
     * @return User
     * @throws FatalRepositoryException
     */
    public function update(
        User $user,
        string $name,
        string $email,
        ?string $password
    ): User {

        $user->setName($name);
        $user->setEmail($email);

        if ($password) {
            $user->setPassword($this->setHashPassword($password));
        }

        if (!$user->save()) {
            throw new FatalRepositoryException('Failed to create/update a user.');
        }

        return $user;
    }

    private function setHashPassword($password): string {
        return Hash::make($password);
    }
}
