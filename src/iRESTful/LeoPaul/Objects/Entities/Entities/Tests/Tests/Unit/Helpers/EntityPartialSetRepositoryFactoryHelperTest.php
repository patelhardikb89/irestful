<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntityPartialSetRepositoryFactoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class EntityPartialSetRepositoryFactoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityPartialSetRepositoryFactoryMock;
    private $entityPartialSetRepositoryMock;
    private $helper;
    public function setUp() {
        $this->entityPartialSetRepositoryFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Factories\EntityPartialSetRepositoryFactory');
        $this->entityPartialSetRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\EntityPartialSetRepository');

        $this->helper = new EntityPartialSetRepositoryFactoryHelper($this, $this->entityPartialSetRepositoryFactoryMock);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $this->helper->expectsCreate_Success($this->entityPartialSetRepositoryMock);

        $repository = $this->entityPartialSetRepositoryFactoryMock->create();

        $this->assertEquals($this->entityPartialSetRepositoryMock, $repository);

    }

    public function testCreate_throwsEntityPartialSetException() {

        $this->helper->expectsCreate_throwsEntityPartialSetException();

        $asserted = false;
        try {

            $this->entityPartialSetRepositoryFactoryMock->create();

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
