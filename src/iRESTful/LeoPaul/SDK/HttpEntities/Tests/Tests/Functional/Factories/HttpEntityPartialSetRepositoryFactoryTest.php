<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Tests\Tests\Functional\Factories;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Factories\HttpEntityPartialSetRepositoryFactory;

final class HttpEntityPartialSetRepositoryFactoryTest extends \PHPUnit_Framework_TestCase {
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

        $this->factory = new HttpEntityPartialSetRepositoryFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $baseUrl);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $repository = $this->factory->create();

        $this->assertTrue($repository instanceof \iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\EntityPartialSetRepository);

    }

}
