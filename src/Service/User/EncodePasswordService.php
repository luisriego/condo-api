<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User;
use App\Exception\Password\PasswordException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class EncodePasswordService
{
    private const MINIMUM_LENGTH = 6;

    public function __construct(private UserPasswordEncoderInterface $userPasswordEncoder)
    { }

    public function generateEncodedPassword(UserInterface $user, string $password)
    {
        if (self::MINIMUM_LENGTH > \strlen($password)) {
            throw PasswordException::invalidLength();
        }


        return $this->userPasswordEncoder->encodePassword($user, $password);
    }

    public function isValidPassword(User $user, string $oldPassword): bool
    {
        return $this->userPasswordEncoder->isPasswordValid($user, $oldPassword);
    }
}