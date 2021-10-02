<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\User;

use App\Entity\User;
use App\Exception\User\UserNotFoundException;
use App\Service\User\ActivateUserService;

class ActivateAccountServiceTest extends UserServiceTestBase
{
    private ActivateUserService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new ActivateUserService($this->userRepository, $this->encoderService);
    }

    public function testActivateUser(): void
    {
        $user = new User('user', 'user@mail.com');
        $password = 'password';

        $this->userRepository
            ->expects($this->exactly(1))
            ->method('findOneInactiveByEmailAndTokenOrFail')
            ->with($user->getEmail(), $user->getToken())
            ->willReturn($user);

        $this->encoderService
            ->expects($this->exactly(1))
            ->method('generateEncodedPassword')
            ->with($user, $password)
            ->willReturn($password);

        $user = $this->service->__invoke($user->getEmail(), $user->getToken(), $password);

        self::assertInstanceOf(User::class, $user);
        self::assertNull($user->getToken());
        self::assertTrue($user->isActive());
        self::assertNotEmpty($user->getPassword());
    }

    public function testActivateUserWithNotExistingUser(): void
    {
        $email = 'user@mail.com';
        $token = \sha1(\uniqid());
        $password = 'password';

        $this->userRepository
            ->expects($this->exactly(1))
            ->method('findOneInactiveByEmailAndTokenOrFail')
            ->with($email, $token)
            ->willThrowException(new UserNotFoundException(\sprintf('User with email %s and token %s not found', $email, $token)));

        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage(\sprintf('User with email %s and token %s not found', $email, $token));

        $this->service->__invoke($email, $token, $password);
    }
}