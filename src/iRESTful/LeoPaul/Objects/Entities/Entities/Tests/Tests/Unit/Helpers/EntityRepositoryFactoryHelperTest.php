<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntityRepositoryFactoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class EntityRepositoryFactoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityRepositoryFactoryMock;
    private $entityRepositoryMock;
    private $helper;
    public function setUp() {
        $this->entityRepositoryFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Factories\EntityRepositoryFactory');
        $this->entityRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository');

        $this->helper = new EntityRepositoryFactoryHelper($this, $this->entityRepositoryFactoryMock);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $this->helper->expectsCreate_Success($this->entityRepositoryMock);

        $repository = $this->entityRepositoryFactoryMock->create();

        $this->assertEquals($this->entityRepositoryMock, $repository);

    }

    public function testCreate_throwsEntityException() {

        $this->helper->expectsCreate_throwsEntityException();

        $asserted = false;
        try {

            $this->entityRepositoryFactoryMock->create();

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
