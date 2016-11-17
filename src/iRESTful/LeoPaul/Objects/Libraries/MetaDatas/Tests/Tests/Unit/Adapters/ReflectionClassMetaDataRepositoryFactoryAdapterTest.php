<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ReflectionClassMetaDataRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionClassMetaDataRepositoryFactory;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Exceptions\ClassMetaDataException;

final class ReflectionClassMetaDataRepositoryFactoryAdapterTest extends \PHPUnit_Framework_TestCase {
    private $data;
    private $adapter;
    private $factory;
    public function setUp() {

        $containerClassMapper = [
            'my_container' => '/Some/ClassName'
        ];

        $interfaceClassMapper = [
            'MyInterface' => '/Some/ClassName'
        ];

        $this->data = [
            'container_class_mapper' => $containerClassMapper,
            'interface_class_mapper' => $interfaceClassMapper
        ];

        $this->adapter = new ReflectionClassMetaDataRepositoryFactoryAdapter();
        $this->factory = new ReflectionClassMetaDataRepositoryFactory($containerClassMapper, $interfaceClassMapper);
    }

    public function tearDown() {

    }

    public function testFromDataToClassMetaDataRepositoryFactory_Success() {

        $factory = $this->adapter->fromDataToClassMetaDataRepositoryFactory($this->data);

        $this->assertEquals($this->factory, $factory);

    }

    public function testFromDataToClassMetaDataRepositoryFactory_withoutContainerClassMapper_throwsClassMetaDataException() {

        unset($this->data['container_class_mapper']);

        $asserted = false;
        try {

            $this->adapter->fromDataToClassMetaDataRepositoryFactory($this->data);

        } catch (ClassMetaDataException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToClassMetaDataRepositoryFactory_withoutInterfaceClassMapper_throwsClassMetaDataException() {

        unset($this->data['interface_class_mapper']);

        $asserted = false;
        try {

            $this->adapter->fromDataToClassMetaDataRepositoryFactory($this->data);

        } catch (ClassMetaDataException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
