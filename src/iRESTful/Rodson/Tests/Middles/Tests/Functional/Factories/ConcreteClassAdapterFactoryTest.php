<?php
namespace iRESTful\Rodson\Tests\Tests\Functional\Factories;
use iRESTful\Rodson\Infrastructure\Middles\Factories\ConcreteClassAdapterFactory;

final class ConcreteClassAdapterFactoryTest extends \PHPUnit_Framework_TestCase {
    private $baseNamespace;
    private $factory;
    public function setUp() {
        $this->baseNamespace = ['iRESTful'];
        $this->factory = new ConcreteClassAdapterFactory($this->baseNamespace);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {
        $adapter = $this->factory->create();
        $this->assertTrue($adapter instanceof \iRESTful\Rodson\Domain\Middles\Classes\Adapters\ClassAdapter);
    }

}
