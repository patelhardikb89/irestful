<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories\EntityRepositoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\OutputEntityException;

final class EntityRepositoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityRepositoryMock;
    private $entityMock;
    private $criteria;
    private $helper;
    public function setUp() {
        $this->entityRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->criteria = [
            'container' => 'my_container',
            'uuid' => 'f9cf73aa-5660-4214-a6be-73527b9f7c84'
        ];

        $this->helper = new EntityRepositoryHelper($this, $this->entityRepositoryMock);
    }

    public function tearDown() {

    }

    public function testExists_Success() {

        $this->helper->expectsExists_Success(true, $this->criteria);

        $exists = $this->entityRepositoryMock->exists($this->criteria);

        $this->assertTrue($exists);

    }

    public function testExists_throwsEntityException() {

        $this->helper->expectsExists_throwsEntityException($this->criteria);

        $asserted = false;
        try {

            $this->entityRepositoryMock->exists($this->criteria);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_Success() {

        $this->helper->expectsRetrieve_Success($this->entityMock, $this->criteria);

        $entity = $this->entityRepositoryMock->retrieve($this->criteria);

        $this->assertEquals($this->entityMock, $entity);

    }

    public function testRetrieve_returnsNull_Success() {

        $this->helper->expectsRetrieve_returnedNull_Success($this->criteria);

        $entity = $this->entityRepositoryMock->retrieve($this->criteria);

        $this->assertNull($entity);

    }

    public function testRetrieve_throwsEntityException() {

        $this->helper->expectsRetrieve_throwsEntityException($this->criteria);

        $asserted = false;
        try {

            $this->entityRepositoryMock->retrieve($this->criteria);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_throwsOutputEntityException() {

        $this->helper->expectsRetrieve_throwsOutputEntityException($this->criteria);

        $asserted = false;
        try {

            $this->entityRepositoryMock->retrieve($this->criteria);

        } catch (OutputEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
