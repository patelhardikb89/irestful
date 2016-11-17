<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Tests\Tests\Functional\Adapters;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityPartialSetRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Factories\HttpEntityPartialSetRepositoryFactory;

final class HttpEntityPartialSetRepositoryFactoryAdapterTest extends \PHPUnit_Framework_TestCase {
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

        $this->factory = new HttpEntityPartialSetRepositoryFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $baseUrl);
        $this->factoryWithPort = new HttpEntityPartialSetRepositoryFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $baseUrl, null, $port);
        $this->factoryWithHeaders = new HttpEntityPartialSetRepositoryFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $baseUrl, $headers);
        $this->factoryWithPortWithHeaders = new HttpEntityPartialSetRepositoryFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $baseUrl, $headers, $port);


        $this->adapter = new HttpEntityPartialSetRepositoryFactoryAdapter();
    }
    
    public function tearDown() {

    }

    public function testFromDataToEntityPartialSetRepositoryFactory_Success() {

        $factory = $this->adapter->fromDataToEntityPartialSetRepositoryFactory($this->data);

        $this->assertEquals($this->factory, $factory);

    }

    public function testFromDataToEntityPartialSetRepositoryFactory_withPort_Success() {

        $factory = $this->adapter->fromDataToEntityPartialSetRepositoryFactory($this->dataWithPort);

        $this->assertEquals($this->factoryWithPort, $factory);

    }

    public function testFromDataToEntityPartialSetRepositoryFactory_withHeaders_Success() {

        $factory = $this->adapter->fromDataToEntityPartialSetRepositoryFactory($this->dataWithHeaders);

        $this->assertEquals($this->factoryWithHeaders, $factory);

    }

    public function testFromDataToEntityPartialSetRepositoryFactory_withPort_withHeaders_Success() {

        $factory = $this->adapter->fromDataToEntityPartialSetRepositoryFactory($this->dataWithPortAndHeaders);

        $this->assertEquals($this->factoryWithPortWithHeaders, $factory);

    }

    public function testFromDataToEntityPartialSetRepositoryFactory_withoutTransformerObejcts_Success() {

        unset($this->data['transformer_objects']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetRepositoryFactory($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityPartialSetRepositoryFactory_withoutContainerClassMapper_Success() {

        unset($this->data['container_class_mapper']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetRepositoryFactory($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityPartialSetRepositoryFactory_withoutInterfaceClassMapper_Success() {

        unset($this->data['interface_class_mapper']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetRepositoryFactory($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityPartialSetRepositoryFactory_withoutDelimiter_Success() {

        unset($this->data['delimiter']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetRepositoryFactory($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityPartialSetRepositoryFactory_withoutBaseUrl_Success() {

        unset($this->data['base_url']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetRepositoryFactory($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
