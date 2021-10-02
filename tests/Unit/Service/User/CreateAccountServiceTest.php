<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\User;

use App\Entity\User;
use App\Exception\User\UserAlreadyExistsException;
use App\Service\User\CreateUserService;
use Doctrine\ORM\ORMException;
use phpDocumentor\Reflection\Types\Boolean;

class CreateAccountServiceTest extends UserServiceTestBase
{
    private CreateUserService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new CreateUserService($this->userRepository);
    }

    public function testCreateUser(): void
    {
        $name = 'user';
        $email = 'user@mail.com';

        $user = $this->service->__invoke($name, $email);

        self::assertInstanceOf(User::class, $user);
        self::assertEquals($name, $user->getName());
        self::assertEquals($email, $user->getEmail());
    }

    public function testCreateUserWichAlreadyExist(): void
    {
        $name = 'user';
        $email = 'user@mail.com';

        $this->userRepository
            ->expects(self::exactly(1))
            ->method('save')
            ->with(self::isType('object'))
            ->willThrowException(new ORMException());

        $this->expectException(UserAlreadyExistsException::class);

        $user = $this->service->__invoke($name, $email);
    }
}