<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ReflectionObjectAdapterFactoryAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionObjectAdapterFactory;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Exceptions\ObjectException;

final class ReflectionObjectAdapterFactoryAdapterTest extends \PHPUnit_Framework_TestCase {
    private $data;
    private $adapter;
    private $factory;
    public function setUp() {

        $transformerObjects = [
            'some' => 'objects'
        ];

        $containerClassMapper = [
            'my_container' => '/Some/ClassName'
        ];

        $interfaceClassMapper = [
            'MyInterface' => '/Some/ClassName'
        ];

        $delimiter = '___';

        $this->data = [
            'transformer_objects' => $transformerObjects,
            'container_class_mapper' => $containerClassMapper,
            'interface_class_mapper' => $interfaceClassMapper,
            'delimiter' => $delimiter
        ];

        $this->adapter = new ReflectionObjectAdapterFactoryAdapter();
        $this->factory = new ReflectionObjectAdapterFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter);
    }

    public function tearDown() {

    }

    public function testFromDataToObjectAdapterFactory_Success() {

        $factory = $this->adapter->fromDataToObjectAdapterFactory($this->data);

        $this->assertEquals($this->factory, $factory);
    }

    public function testFromDataToObjectAdapterFactory_withoutTransformerObjects_throwsObjectException() {

        unset($this->data['transformer_objects']);

        $asserted = false;
        try {

            $this->adapter->fromDataToObjectAdapterFactory($this->data);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToObjectAdapterFactory_withoutContainerClassMapper_throwsObjectException() {

        unset($this->data['container_class_mapper']);

        $asserted = false;
        try {

            $this->adapter->fromDataToObjectAdapterFactory($this->data);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToObjectAdapterFactory_withoutInterfaceClassMapper_throwsObjectException() {

        unset($this->data['interface_class_mapper']);

        $asserted = false;
        try {

            $this->adapter->fromDataToObjectAdapterFactory($this->data);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToObjectAdapterFactory_withoutDelimiter_throwsObjectException() {

        unset($this->data['delimiter']);

        $asserted = false;
        try {

            $this->adapter->fromDataToObjectAdapterFactory($this->data);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
