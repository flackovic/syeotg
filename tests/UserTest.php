<?php

namespace App\Tests;

use App\Entity\Client;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserTest extends TestCase
{
    const ROLE_USER = 'ROLE_USER';

    /** @var User */
    private $user;
    /** @var Client */
    private $clientMock;

    public function setUp()
    {
        $this->user = new User();
        $this->clientMock = $this->createMock(Client::class);
    }

    public function testUsertWillNotHaveUuidWhenCreated()
    {
        $this->assertNull($this->user->getUuid());
    }

    public function testSetUuidWillSetValidUuid()
    {
        $this->user->setUuid();

        $this->assertNotNull($this->user->getUuid());
        $this->assertTrue(Uuid::isValid($this->user->getUuid()));
    }

    public function testUserIsDisabledWhenCreated()
    {
        $this->assertFalse($this->user->isEnabled());
    }

    public function testUserWillHaveRoleUserWhenCreated()
    {
        $this->assertSame([self::ROLE_USER], $this->user->getRoles());
    }

    public function testUserIsNotSuperAdminWhenCreated()
    {
        $this->assertFalse($this->user->isSuperAdmin());
    }

    public function testUserAccountIsNonExpiredWhenCreated()
    {
        $this->assertTrue($this->user->isAccountNonExpired());
    }

    public function testUserShouldNotHaveClientWhenCreated()
    {
        $this->assertNull($this->user->getClient());
    }

    public function testSetClientWorks()
    {
        $this->user->setClient($this->clientMock);

        $this->assertSame($this->clientMock, $this->user->getClient());
    }

    public function testSetClientWillThrowExceptionIfGivenClientId()
    {
        $this->expectException('TypeError');

        $this->user->setClient(1);
    }

    public function testSetClientWillThrowExceptionIfGivenClientUuid()
    {
        $this->expectException('TypeError');

        $this->user->setClient('db58cb6c-3cff-4ba5-b17b-8f74f4ec3927');
    }
}
