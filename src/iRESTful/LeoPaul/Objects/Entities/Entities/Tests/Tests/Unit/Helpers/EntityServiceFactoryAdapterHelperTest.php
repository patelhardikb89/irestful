<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityServiceFactoryAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class EntityServiceFactoryAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityServiceFactoryAdapterMock;
    private $entityServiceFactoryMock;
    private $data;
    private $helper;
    public function setUp() {
        $this->entityServiceFactoryAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\Factories\Adapters\EntityServiceFactoryAdapter');
        $this->entityServiceFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\Factories\EntityServiceFactory');

        $this->data = [
            'some' => 'data'
        ];

        $this->helper = new EntityServiceFactoryAdapterHelper($this, $this->entityServiceFactoryAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToEntityServiceFactory_Success() {

        $this->helper->expectsFromDataToEntityServiceFactory_Success($this->entityServiceFactoryMock, $this->data);

        $factory = $this->entityServiceFactoryAdapterMock->fromDataToEntityServiceFactory($this->data);

        $this->assertEquals($factory, $this->entityServiceFactoryMock);

    }

    public function testFromDataToEntityServiceFactory_throwsEntityException() {

        $this->helper->expectsFromDataToEntityServiceFactory_throwsEntityException($this->data);

        $asserted = false;
        try {

            $this->entityServiceFactoryAdapterMock->fromDataToEntityServiceFactory($this->data);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
