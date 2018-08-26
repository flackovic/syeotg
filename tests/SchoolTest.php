<?php

namespace App\Tests;

use App\Entity\Client;
use App\Entity\School;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class SchoolTest extends TestCase
{
    /** @var School */
    private $school;
    /** @var Client */
    private $clientMock;

    public function setUp()
    {
        $this->school = new School();
        $this->clientMock = $this->createMock(Client::class);
    }

    public function testSchoolWillNotHaveUuidWhenCreated()
    {
        $this->assertNull($this->school->getUuid());
    }

    public function testSetUuidWillSetValidUuid()
    {
        $this->school->setUuid();

        $this->assertNotNull($this->school->getUuid());
        $this->assertTrue(Uuid::isValid($this->school->getUuid()));
    }

    public function testUserShouldNotHaveClientWhenCreated()
    {
        $this->assertNull($this->school->getClient());
    }

    public function testSetClientWorks()
    {
        $this->school->setClient($this->clientMock);

        $this->assertSame($this->clientMock, $this->school->getClient());
    }

    public function testSetClientWillThrowExceptionIfGivenClientId()
    {
        $this->expectException('TypeError');

        $this->school->setClient(1);
    }

    public function testSetClientWillThrowExceptionIfGivenClientUuid()
    {
        $this->expectException('TypeError');

        $this->school->setClient('db58cb6c-3cff-4ba5-b17b-8f74f4ec3927');
    }
}
