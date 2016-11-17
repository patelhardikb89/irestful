<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Factories\ReflectionEntityAdapterAdapterFactory;

final class ReflectionEntityAdapterAdapterFactoryTest extends \PHPUnit_Framework_TestCase {
    private $data;
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

        $this->factory = new ReflectionEntityAdapterAdapterFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $entityAdapterAdapter = $this->factory->create();

        $this->assertTrue($entityAdapterAdapter instanceof \iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Adapters\EntityAdapterAdapter);

    }

}
