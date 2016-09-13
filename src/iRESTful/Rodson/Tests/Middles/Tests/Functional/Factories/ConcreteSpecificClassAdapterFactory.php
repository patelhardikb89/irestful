<?php
namespace iRESTful\Rodson\Tests\Tests\Functional\Factories;
use iRESTful\Rodson\Infrastructure\Middles\Factories\ConcreteSpecificClassAdapterFactory;
use iRESTful\Rodson\Infrastructure\Middles\Factories\ConcreteAnnotationAdapterFactory;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteSpecificClassEntityAnnotatedAdapter;

final class ConcreteSpecificClassAdapterFactoryTest extends \PHPUnit_Framework_TestCase {
    private $baseNamespace;
    private $factory;
    public function setUp() {

        $this->factory = new ConcreteSpecificClassAdapterFactory(
            '___',
            'America/Montreal'
        );
    }

    public function tearDown() {

    }

    public function testCreate_Success() {
        $adapter = $this->factory->create();
        $this->assertTrue($adapter instanceof \iRESTful\Rodson\Domain\Middles\Classes\Adapters\SpecificClassAdapter);
    }

}
