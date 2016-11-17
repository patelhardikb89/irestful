<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Tests\Tests\Functional\Adapters;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRelationRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Factories\HttpEntityRelationRepositoryFactory;

final class HttpEntityRelationRepositoryFactoryAdapterTest extends \PHPUnit_Framework_TestCase {
    private $data;
    private $dataWithPort;
    private $dataWithHeaders;
    private $dataWithPortAndHeaders;
    private $adapter;
    private $factory;
    private $factoryWithPort;
    private $factoryWithHeaders;
    private $factoryWithPortWithHeaders;
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
        $baseUrl = 'http://apis.irestful.dev';
        $headers = [
            'some' => 'headers'
        ];

        $port = rand(1, 800);

        $this->data = [
            'transformer_objects' => $transformerObjects,
            'container_class_mapper' => $containerClassMapper,
            'interface_class_mapper' => $interfaceClassMapper,
            'delimiter' => $delimiter,
            'base_url' => $baseUrl
        ];

        $this->dataWithPort = [
            'transformer_objects' => $transformerObjects,
            'container_class_mapper' => $containerClassMapper,
            'interface_class_mapper' => $interfaceClassMapper,
            'delimiter' => $delimiter,
            'base_url' => $baseUrl,
            'port' => $port
        ];

        $this->dataWithHeaders = [
            'transformer_objects' => $transformerObjects,
            'container_class_mapper' => $containerClassMapper,
            'interface_class_mapper' => $interfaceClassMapper,
            'delimiter' => $delimiter,
            'base_url' => $baseUrl,
            'headers' => $headers
        ];

        $this->dataWithPortAndHeaders = [
            'transformer_objects' => $transformerObjects,
            'container_class_mapper' => $containerClassMapper,
            'interface_class_mapper' => $interfaceClassMapper,
            'delimiter' => $delimiter,
            'base_url' => $baseUrl,
            'headers' => $headers,
            'port' => $port
        ];

        $this->factory = new HttpEntityRelationRepositoryFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $baseUrl);
        $this->factoryWithPort = new HttpEntityRelationRepositoryFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $baseUrl, null, $port);
        $this->factoryWithHeaders = new HttpEntityRelationRepositoryFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $baseUrl, $headers);
        $this->factoryWithPortWithHeaders = new HttpEntityRelationRepositoryFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $baseUrl, $headers, $port);


        $this->adapter = new HttpEntityRelationRepositoryFactoryAdapter();
    }
    public function tearDown() {

    }

    public function testFromDataToEntityRelationRepositoryFactory_Success() {

        $factory = $this->adapter->fromDataToEntityRelationRepositoryFactory($this->data);

        $this->assertEquals($this->factory, $factory);

    }

    public function testFromDataToEntityRelationRepositoryFactory_withPort_Success() {

        $factory = $this->adapter->fromDataToEntityRelationRepositoryFactory($this->dataWithPort);

        $this->assertEquals($this->factoryWithPort, $factory);

    }

    public function testFromDataToEntityRelationRepositoryFactory_withHeaders_Success() {

        $factory = $this->adapter->fromDataToEntityRelationRepositoryFactory($this->dataWithHeaders);

        $this->assertEquals($this->factoryWithHeaders, $factory);

    }

    public function testFromDataToEntityRelationRepositoryFactory_withPort_withHeaders_Success() {

        $factory = $this->adapter->fromDataToEntityRelationRepositoryFactory($this->dataWithPortAndHeaders);

        $this->assertEquals($this->factoryWithPortWithHeaders, $factory);

    }

    public function testFromDataToEntityRelationRepositoryFactory_withoutTransformerObejcts_Success() {

        unset($this->data['transformer_objects']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityRelationRepositoryFactory($this->data);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityRelationRepositoryFactory_withoutContainerClassMapper_Success() {

        unset($this->data['container_class_mapper']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityRelationRepositoryFactory($this->data);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityRelationRepositoryFactory_withoutInterfaceClassMapper_Success() {

        unset($this->data['interface_class_mapper']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityRelationRepositoryFactory($this->data);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityRelationRepositoryFactory_withoutDelimiter_Success() {

        unset($this->data['delimiter']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityRelationRepositoryFactory($this->data);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityRelationRepositoryFactory_withoutBaseUrl_Success() {

        unset($this->data['base_url']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityRelationRepositoryFactory($this->data);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
