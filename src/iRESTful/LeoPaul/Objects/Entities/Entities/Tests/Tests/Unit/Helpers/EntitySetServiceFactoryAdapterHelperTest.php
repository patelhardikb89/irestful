<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntitySetServiceFactoryAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class EntitySetServiceFactoryAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $entitySetServiceFactoryAdapterMock;
    private $entitySetServiceFactoryMock;
    private $data;
    private $helper;
    public function setUp() {
        $this->entitySetServiceFactoryAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\Factories\Adapters\EntitySetServiceFactoryAdapter');
        $this->entitySetServiceFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\Factories\EntitySetServiceFactory');

        $this->data = [
            'some' => 'data'
        ];

        $this->helper = new EntitySetServiceFactoryAdapterHelper($this, $this->entitySetServiceFactoryAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToEntitySetServiceFactory_Success() {

        $this->helper->expectsFromDataToEntitySetServiceFactory_Success($this->entitySetServiceFactoryMock, $this->data);

        $factory = $this->entitySetServiceFactoryAdapterMock->fromDataToEntitySetServiceFactory($this->data);

        $this->assertEquals($this->entitySetServiceFactoryMock, $factory);

    }

    public function testFromDataToEntitySetServiceFactory_throwsEntitySetException() {

        $this->helper->expectsFromDataToEntitySetServiceFactory_throwsEntitySetException($this->data);

        $asserted = false;
        try {

            $this->entitySetServiceFactoryAdapterMock->fromDataToEntitySetServiceFactory($this->data);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
