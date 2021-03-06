<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Tests\Tests\Functional;
use iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Factories\StrategyEntityRepositoryFactory;

final class StrategyRepositoryFactoryTest extends \PHPUnit_Framework_TestCase {
    private $factory;
    public function setUp() {

        $containerRepositoryMapper = [
            'my_container' => $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository')
        ];

        $this->factory = new StrategyEntityRepositoryFactory($containerRepositoryMapper);

    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $repository = $this->factory->create();

        $this->assertTrue($repository instanceof \iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Repositories\StrategyEntityRepository);

    }

}
