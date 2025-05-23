<?php

namespace App\Repositories\User;

use App\Models\Factories\User\UserFactory;
use App\Models\User;
use App\Modules\Exceptions\FatalModuleException;
use App\Modules\Exceptions\FatalRepositoryException;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{
    private UserFactory $userFactory;

    /**
     * @param UserFactory $userFactory
     */
    public function __construct(
        UserFactory $userFactory,
    ) {
        $this->userFactory = $userFactory;
    }

    public function getById(int $id): ?User
    {
        return $this->userFactory->getById($id);
    }

    /**
     * @param string $email
     * @return ?User
     */
    public function getByEmail(string $email): ?User
    {
        return $this->userFactory->getByEmail($email);
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
        ?string $password,
    ): User {
        return $this->userFactory->create($name, $email, $password);
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

        return $this->userFactory->update($user, $name, $email, $password);
    }

    /**
     * @param User $user
     * @return bool
     * @throws FatalModuleException
     */
    public function delete(User $user): bool
    {
        return $this->userFactory->delete($user);
    }

    public function getCurrentUser(): ?User
    {
        /** User $user */
        $user = Auth::user();

        if (!$user) {
            throw new FatalModuleException("User is not authenticated");
        }

        return $this->userFactory->getById($user->getId());
    }

}
