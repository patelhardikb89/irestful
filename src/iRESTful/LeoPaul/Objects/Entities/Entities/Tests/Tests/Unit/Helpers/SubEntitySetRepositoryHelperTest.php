<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories\SubEntitySetRepositoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Exceptions\SubEntityException;

final class SubEntitySetRepositoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $subEntitySetRepositoryMock;
    private $subEntitiesMock;
    private $entityMock;
    private $entities;
    private $helper;
    public function setUp() {
        $this->subEntitySetRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Sets\Repositories\SubEntitySetRepository');
        $this->subEntitiesMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\SubEntities');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->entities = [
            $this->entityMock,
            $this->entityMock
        ];

        $this->helper = new SubEntitySetRepositoryHelper($this, $this->subEntitySetRepositoryMock);
    }

    public function tearDown() {

    }

    public function testRetrieve_Success() {

        $this->helper->expectsRetrieve_Success($this->subEntitiesMock, $this->entities);

        $subEntities = $this->subEntitySetRepositoryMock->retrieve($this->entities);

        $this->assertEquals($this->subEntitiesMock, $subEntities);

    }

    public function testRetrieve_returnsNull_Success() {

        $this->helper->expectsRetrieve_returnsNull_Success($this->entities);

        $subEntities = $this->subEntitySetRepositoryMock->retrieve($this->entities);

        $this->assertNull($subEntities);

    }

    public function testRetrieve_multiple_Success() {

        $this->helper->expectsRetrieve_multiple_Success([$this->subEntitiesMock, $this->subEntitiesMock], [$this->entities, $this->entities]);

        $firstSubEntities = $this->subEntitySetRepositoryMock->retrieve($this->entities);
        $secondSubEntities = $this->subEntitySetRepositoryMock->retrieve($this->entities);

        $this->assertEquals($this->subEntitiesMock, $firstSubEntities);
        $this->assertEquals($this->subEntitiesMock, $secondSubEntities);

    }

    public function testRetrieve_throwsSubEntityException() {

        $this->helper->expectsRetrieve_throwsSubEntityException($this->entities);

        $asserted = false;
        try {

            $this->subEntitySetRepositoryMock->retrieve($this->entities);

        } catch (SubEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
