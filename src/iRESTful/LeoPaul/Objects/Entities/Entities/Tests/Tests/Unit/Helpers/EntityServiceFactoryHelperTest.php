<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntityServiceFactoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class EntityServiceFactoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityServiceFactoryMock;
    private $entityServiceMock;
    private $helper;
    public function setUp() {
        $this->entityServiceFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\Factories\EntityServiceFactory');
        $this->entityServiceMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\EntityService');

        $this->helper = new EntityServiceFactoryHelper($this, $this->entityServiceFactoryMock);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $this->helper->expectsCreate_Success($this->entityServiceMock);

        $service = $this->entityServiceFactoryMock->create();

        $this->assertEquals($this->entityServiceMock, $service);

    }

    public function testCreate_throwsEntityException() {

        $this->helper->expectsCreate_throwsEntityException();

        $asserted = false;
        try {

            $this->entityServiceFactoryMock->create();

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
