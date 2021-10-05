<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\User;

use App\Repository\DoctrineUserRepository;
use App\Service\User\EncodePasswordService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserServiceTestBase extends TestCase
{
    /** @var DoctrineUserRepository|MockObject */
    protected $userRepository;

    /** @var EncodePasswordService|MockObject */
    protected $encoderService;

//    /** @var MessageBusInterface|MockObject */
//    protected $messageBus;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->getMockBuilder(DoctrineUserRepository::class)->disableOriginalConstructor()->getMock();
        $this->encoderService = $this->getMockBuilder(EncodePasswordService::class)->disableOriginalConstructor()->getMock();
//        $this->messageBus = $this->getMockBuilder(MessageBusInterface::class)->disableOriginalConstructor()->getMock();
    }
}