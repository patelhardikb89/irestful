<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Tests\Tests\Functional;
use iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Factories\StrategyEntityAdapterFactory;

final class StrategyEtityAdapterFactoryTest extends \PHPUnit_Framework_TestCase {
    private $factory;
    public function setUp() {

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

        $this->factory = new StrategyEntityAdapterFactory($containerRepositoryMapper, $transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $entityAdapter = $this->factory->create();

        $this->assertTrue($entityAdapter instanceof \iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter);

    }

}
