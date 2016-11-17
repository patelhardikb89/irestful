<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Tests\Tests\Functional\Factories;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Factories\HttpEntityRelationRepositoryFactory;

final class HttpEntityRelationRepositoryFactoryTest extends \PHPUnit_Framework_TestCase {
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

        $this->factory = new HttpEntityRelationRepositoryFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $baseUrl);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $repository = $this->factory->create();

        $this->assertTrue($repository instanceof \iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository);

    }

}
