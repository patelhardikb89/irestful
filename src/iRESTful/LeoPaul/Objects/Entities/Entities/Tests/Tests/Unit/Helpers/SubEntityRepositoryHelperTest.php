<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories\SubEntityRepositoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Exceptions\SubEntityException;

final class SubEntityRepositoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $subEntityRepositoryMock;
    private $subEntitiesMock;
    private $entityMock;
    private $helper;
    public function setUp() {
        $this->subEntityRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Repositories\SubEntityRepository');
        $this->subEntitiesMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\SubEntities');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->helper = new SubEntityRepositoryHelper($this, $this->subEntityRepositoryMock);
    }

    public function tearDown() {

    }

    public function testRetrieve_Success() {

        $this->helper->expectsRetrieve_Success($this->subEntitiesMock, $this->entityMock);

        $subEntities = $this->subEntityRepositoryMock->retrieve($this->entityMock);

        $this->assertEquals($this->subEntitiesMock, $subEntities);

    }

    public function testRetrieve_returnsNull_Success() {

        $this->helper->expectsRetrieve_returnsNull_Success($this->entityMock);

        $subEntities = $this->subEntityRepositoryMock->retrieve($this->entityMock);

        $this->assertNull($subEntities);

    }

    public function testRetrieve_multiple_Success() {

        $this->helper->expectsRetrieve_multiple_Success([$this->subEntitiesMock, $this->subEntitiesMock], [$this->entityMock, $this->entityMock]);

        $firstSubEntities = $this->subEntityRepositoryMock->retrieve($this->entityMock);
        $secondSubEntities = $this->subEntityRepositoryMock->retrieve($this->entityMock);

        $this->assertEquals($this->subEntitiesMock, $firstSubEntities);
        $this->assertEquals($this->subEntitiesMock, $secondSubEntities);

    }

    public function testRetrieve_throwsSubEntityException() {

        $this->helper->expectsRetrieve_throwsSubEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->subEntityRepositoryMock->retrieve($this->entityMock);

        } catch (SubEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
