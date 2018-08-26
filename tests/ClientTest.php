<?php

namespace App\Tests;

use App\Entity\Client;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ClientTest extends TestCase
{
    /** @var Client */
    private $client;
    /** @var User */
    private $userMock;

    public function setUp()
    {
        $this->client = new Client();
        $this->userMock = $this->createMock(User::class);
    }

    public function testClientWillNotHaveUuidWhenCreated()
    {
        $this->assertNull($this->client->getUuid());
    }

    public function testSetUuidWillSetValidUuid()
    {
        $this->client->setUuid();

        $this->assertNotNull($this->client->getUuid());
        $this->assertTrue(Uuid::isValid($this->client->getUuid()));
    }

    public function testClientIsInactiveWhenCreated()
    {
        $this->assertFalse($this->client->isActive());
    }

    public function testClientWillBeActiveAfterActivating()
    {
        $this->client->activate();

        $this->assertTrue($this->client->isActive());
    }

    public function testClientWillBeInactiveAfterDeactivating()
    {
        $this->client->activate();
        $this->client->deactivate();

        $this->assertFalse($this->client->isActive());
    }

    public function testAddUserWillThrowExceptionIfGivenUserId()
    {
        $this->expectException('TypeError');

        $this->client->addUser(1);
    }

    public function testAddUserWillThrowExceptionIfGivenUserUuid()
    {
        $this->expectException('TypeError');

        $this->client->addUser('db58cb6c-3cff-4ba5-b17b-8f74f4ec3927');
    }

    public function testAddUserWillThrowExceptionIfGivenArrayOfUsers()
    {
        $this->expectException('TypeError');

        $this->client->addUser([$this->userMock, $this->userMock]);
    }

    public function testAddUserWorks()
    {
        $this->client->addUser($this->userMock);

        $this->assertContains($this->userMock, $this->client->getUsers());
        $this->assertNotEmpty($this->client->getUsers());
    }

    public function testRemoveUserWorks()
    {
        $this->client->addUser($this->userMock);
        $this->client->removeUser($this->userMock);

        $this->assertNotContains($this->userMock, $this->client->getUsers());
        $this->assertEmpty($this->client->getUsers());
    }

    /**
     * @param array $usersToAdd
     * @param $expectedUserCount
     *
     * @dataProvider provideCountUsersData
     */
    public function testCountUsersWillReturnCorrectUserCount(array $usersToAdd, int $expectedUserCount)
    {
        foreach($usersToAdd as $userToAdd) {
            $this->client->addUser($userToAdd);
        }

        $this->assertSame($expectedUserCount, $this->client->countUsers());
    }

    public function provideCountUsersData()
    {
        return [
            [
                [

                ], 0],
            [
                [
                    $this->createMock(User::class)
                ], 1],
            [
                [
                    $this->createMock(User::class),
                    $this->createMock(User::class),
                    $this->createMock(User::class),
                ], 3
            ],
            [
                [
                    $this->createMock(User::class),
                    $this->createMock(User::class),
                    $this->createMock(User::class),
                    $this->createMock(User::class),
                    $this->createMock(User::class),
                    $this->createMock(User::class),
                    $this->createMock(User::class),
                    $this->createMock(User::class),
                    $this->createMock(User::class),
                    $this->createMock(User::class),
                ], 10
            ],
        ];
    }

}
