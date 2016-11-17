<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityRepositoryFactoryAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class EntityRepositoryFactoryAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityRepositoryFactoryAdapterMock;
    private $entityRepositoryFactoryMock;
    private $data;
    private $helper;
    public function setUp() {
        $this->entityRepositoryFactoryAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Factories\Adapters\EntityRepositoryFactoryAdapter');
        $this->entityRepositoryFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Factories\EntityRepositoryFactory');

        $this->data = [
            'some' => 'data'
        ];

        $this->helper = new EntityRepositoryFactoryAdapterHelper($this, $this->entityRepositoryFactoryAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToEntityRepositoryFactory_Success() {

        $this->helper->expectsFromDataToEntityRepositoryFactory_Success($this->entityRepositoryFactoryMock, $this->data);

        $factory = $this->entityRepositoryFactoryAdapterMock->fromDataToEntityRepositoryFactory($this->data);

        $this->assertEquals($this->entityRepositoryFactoryMock, $factory);

    }

    public function testFromDataToEntityRepositoryFactory_throwsEntityException() {

        $this->helper->expectsFromDataToEntityRepositoryFactory_throwsEntityException($this->data);

        $asserted = false;
        try {

            $this->entityRepositoryFactoryAdapterMock->fromDataToEntityRepositoryFactory($this->data);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
