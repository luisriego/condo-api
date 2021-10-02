<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\User;

use App\Entity\User;
use App\Exception\Password\PasswordException;
use App\Service\User\ActivateUserService;
use App\Service\User\ChangePasswordService;

class ChangePasswordServiceTest extends UserServiceTestBase
{
    private ChangePasswordService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new ChangePasswordService($this->userRepository, $this->encoderService);
    }

    public function testChangePassword(): void
    {
        $user = new User('user', 'user@mail.com');
        $oldPass = "password";
        $newPass = "new-password";

        $this->encoderService
            ->expects($this->exactly(1))
            ->method('isValidPassword')
            ->with($user, $oldPass)
            ->willReturn(true);

        $this->encoderService
            ->expects($this->exactly(1))
            ->method('generateEncodedPassword')
            ->with($user, $newPass)
            ->willReturn($newPass);

        $user = $this->service->__invoke($oldPass, $newPass, $user);

        self::assertInstanceOf(User::class, $user);
    }

    public function testChangePasswordFailBecauseOldPassIsIncorrect(): void
    {
        $user = new User('user', 'user@mail.com');
        $oldPass = "password";
        $newPass = "new-password";

        $this->encoderService
            ->expects($this->exactly(1))
            ->method('isValidPassword')
            ->with($user, $oldPass)
            ->willReturn(false);

        $this->expectException(PasswordException::class);

        $this->service->__invoke($oldPass, $newPass, $user);
    }
}