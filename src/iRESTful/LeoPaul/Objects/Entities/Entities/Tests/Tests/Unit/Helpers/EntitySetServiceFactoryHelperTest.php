<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntitySetServiceFactoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class EntitySetServiceFactoryHelperTest extends \PHPUnit_Framework_TestCase {
    private $entitySetServiceFactoryMock;
    private $entitySetServiceMock;
    private $helper;
    public function setUp() {
        $this->entitySetServiceFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\Factories\EntitySetServiceFactory');
        $this->entitySetServiceMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\EntitySetService');

        $this->helper = new EntitySetServiceFactoryHelper($this, $this->entitySetServiceFactoryMock);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $this->helper->expectsCreate_Success($this->entitySetServiceMock);

        $service = $this->entitySetServiceFactoryMock->create();

        $this->assertEquals($this->entitySetServiceMock, $service);

    }

    public function testCreate_throwsEntitySetException() {

        $this->helper->expectsCreate_throwsEntitySetException();

        $asserted = false;
        try {

            $this->entitySetServiceFactoryMock->create();

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
