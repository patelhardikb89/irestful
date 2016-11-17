<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntitySetRepositoryFactoryAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class EntitySetRepositoryFactoryAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $entitySetRepositoryFactoryAdapterMock;
    private $entitySetRepositoryFactoryMock;
    private $data;
    private $helper;
    public function setUp() {
        $this->entitySetRepositoryFactoryAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Factories\Adapters\EntitySetRepositoryFactoryAdapter');
        $this->entitySetRepositoryFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Factories\EntitySetRepositoryFactory');

        $this->data = [
            'some' => 'data'
        ];

        $this->helper = new EntitySetRepositoryFactoryAdapterHelper($this, $this->entitySetRepositoryFactoryAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToEntitySetRepositoryFactory_Success() {

        $this->helper->expectsFromDataToEntitySetRepositoryFactory_Success($this->entitySetRepositoryFactoryMock, $this->data);

        $factory = $this->entitySetRepositoryFactoryAdapterMock->fromDataToEntitySetRepositoryFactory($this->data);

        $this->assertEquals($this->entitySetRepositoryFactoryMock, $factory);

    }

    public function testFromDataToEntitySetRepositoryFactory_throwsEntitySetException() {

        $this->helper->expectsFromDataToEntitySetRepositoryFactory_throwsEntitySetException($this->data);

        $asserted = false;
        try {

            $this->entitySetRepositoryFactoryAdapterMock->fromDataToEntitySetRepositoryFactory($this->data);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
