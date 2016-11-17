<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Tests\Tests\Functional\Factories;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Factories\HttpEntitySetServiceFactory;

final class HttpEntitySetServiceFactoryTest extends \PHPUnit_Framework_TestCase {
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
        $baseUrl = 'http://apis.irestful.dev';

        $this->factory = new HttpEntitySetServiceFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $baseUrl);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $service = $this->factory->create();

        $this->assertTrue($service instanceof \iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\EntitySetService);

    }

}
