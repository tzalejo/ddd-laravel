<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Application;

use DateTime;
use Src\BoundedContext\User\Domain\Contracts\UserRepositoryContract;
use Src\BoundedContext\User\Domain\User;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmail;
use Src\BoundedContext\User\Domain\ValueObjects\UserEmailVerifiedDate;
use Src\BoundedContext\User\Domain\ValueObjects\UserName;
use Src\BoundedContext\User\Domain\ValueObjects\UserPassword;
use Src\BoundedContext\User\Domain\ValueObjects\UserRememberToken;

final class CreateUserUseCase
{
    private $repository;
    // se le inyecta la interfaz UserRepositoryContract
    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(
        string $userName,
        string $userEmail,
        ?DateTime $userEmailVerifiedDate,
        string $userPassword,
        ?string $userRememberToken
    ): void {
        // instancia los value objects del modelo de dominio (aquí el tipo de dato que se le pasa por
        // constructor a cada value object es muy importante y tiene que coincidir con su declaración)
        $name = new UserName($userName);
        $email = new UserEmail($userEmail);
        $emailVerifiedDate = new UserEmailVerifiedDate($userEmailVerifiedDate);
        $password = new UserPassword($userPassword);
        $rememberToken = new UserRememberToken($userRememberToken);

        $user = User::create(
            $name,
            $email,
            $emailVerifiedDate,
            $password,
            $rememberToken
        );

        $this->repository->save($user);
    }
}
