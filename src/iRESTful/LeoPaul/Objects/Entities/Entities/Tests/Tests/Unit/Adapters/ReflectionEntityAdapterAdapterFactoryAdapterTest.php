<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ReflectionEntityAdapterAdapterFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class ReflectionEntityAdapterAdapterFactoryAdapterTest extends \PHPUnit_Framework_TestCase {
    private $data;
    private $adapter;
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

        $this->adapter = new ReflectionEntityAdapterAdapterFactoryAdapter($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter);
    }

    public function tearDown() {

    }

    public function testFromDataToEntityAdapterAdapterFactory_Success() {

        $factory = $this->adapter->fromDataToEntityAdapterAdapterFactory($this->data);

        $this->assertTrue($factory instanceof \iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Adapters\Factories\EntityAdapterAdapterFactory);

    }

    public function testFromDataToEntityAdapterAdapterFactory_withoutTransformerObjects_throwsEntityException() {

        unset($this->data['transformer_objects']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityAdapterAdapterFactory($this->data);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityAdapterAdapterFactory_withoutContainerClassMapper_throwsEntityException() {

        unset($this->data['container_class_mapper']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityAdapterAdapterFactory($this->data);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityAdapterAdapterFactory_withoutInterfaceClassMapper_throwsEntityException() {

        unset($this->data['interface_class_mapper']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityAdapterAdapterFactory($this->data);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityAdapterAdapterFactory_withoutDelimiter_throwsEntityException() {

        unset($this->data['delimiter']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityAdapterAdapterFactory($this->data);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
