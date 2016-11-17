<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntitySetRepositoryFactoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class EntitySetRepositoryFactoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $entitySetRepositoryFactoryMock;
    private $entitySetRepositoryMock;
    private $helper;
    public function setUp() {
        $this->entitySetRepositoryFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Factories\EntitySetRepositoryFactory');
        $this->entitySetRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\EntitySetRepository');

        $this->helper = new EntitySetRepositoryFactoryHelper($this, $this->entitySetRepositoryFactoryMock);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $this->helper->expectsCreate_Success($this->entitySetRepositoryMock);

        $repository = $this->entitySetRepositoryFactoryMock->create();

        $this->assertEquals($this->entitySetRepositoryMock, $repository);

    }

    public function testCreate_throwsEntitySetException() {

        $this->helper->expectsCreate_throwsEntitySetException();

        $asserted = false;
        try {

            $this->entitySetRepositoryFactoryMock->create();

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
