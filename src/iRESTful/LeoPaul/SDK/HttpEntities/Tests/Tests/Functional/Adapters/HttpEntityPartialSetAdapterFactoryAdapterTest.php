<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Tests\Tests\Functional\Adapters;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Factories\HttpEntityPartialSetAdapterFactory;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityPartialSetAdapterFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class HttpEntityPartialSetAdapterFactoryAdapterTest extends \PHPUnit_Framework_TestCase {
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

        $this->factory = new HttpEntityPartialSetAdapterFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $baseUrl);
        $this->factoryWithPort = new HttpEntityPartialSetAdapterFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $baseUrl, null, $port);
        $this->factoryWithHeaders = new HttpEntityPartialSetAdapterFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $baseUrl, $headers);
        $this->factoryWithPortWithHeaders = new HttpEntityPartialSetAdapterFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $baseUrl, $headers, $port);


        $this->adapter = new HttpEntityPartialSetAdapterFactoryAdapter();
    }

    public function tearDown() {

    }

    public function testFromDataToEntityPartialSetAdapterFactory_Success() {

        $factory = $this->adapter->fromDataToEntityPartialSetAdapterFactory($this->data);

        $this->assertEquals($this->factory, $factory);

    }

    public function testFromDataToEntityPartialSetAdapterFactory_withPort_Success() {

        $factory = $this->adapter->fromDataToEntityPartialSetAdapterFactory($this->dataWithPort);

        $this->assertEquals($this->factoryWithPort, $factory);

    }

    public function testFromDataToEntityPartialSetAdapterFactory_withHeaders_Success() {

        $factory = $this->adapter->fromDataToEntityPartialSetAdapterFactory($this->dataWithHeaders);

        $this->assertEquals($this->factoryWithHeaders, $factory);

    }

    public function testFromDataToEntityPartialSetAdapterFactory_withPort_withHeaders_Success() {

        $factory = $this->adapter->fromDataToEntityPartialSetAdapterFactory($this->dataWithPortAndHeaders);

        $this->assertEquals($this->factoryWithPortWithHeaders, $factory);

    }

    public function testFromDataToEntityPartialSetAdapterFactory_withoutTransformerObejcts_Success() {

        unset($this->data['transformer_objects']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetAdapterFactory($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityPartialSetAdapterFactory_withoutContainerClassMapper_Success() {

        unset($this->data['container_class_mapper']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetAdapterFactory($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityPartialSetAdapterFactory_withoutInterfaceClassMapper_Success() {

        unset($this->data['interface_class_mapper']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetAdapterFactory($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityPartialSetAdapterFactory_withoutDelimiter_Success() {

        unset($this->data['delimiter']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetAdapterFactory($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityPartialSetAdapterFactory_withoutBaseUrl_Success() {

        unset($this->data['base_url']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetAdapterFactory($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }
}
