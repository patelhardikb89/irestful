<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Tests\Tests\Functional;
use iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Factories\StrategyEntityServiceFactory;

final class StrategyEntityServiceFactoryTest extends \PHPUnit_Framework_TestCase {
    private $factory;
    public function setUp() {

        $containerServiceMapper = [
            'my_container' => $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\EntityService')
        ];

        $containerRepositoryMapper = [
            'my_container' => $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository')
        ];

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

        $this->factory = new StrategyEntityServiceFactory($containerServiceMapper, $containerRepositoryMapper, $transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter);

    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $service = $this->factory->create();

        $this->assertTrue($service instanceof \iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Services\StrategyEntityService);

    }

}
