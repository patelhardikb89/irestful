<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Adapters;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteNamespaceAdapter;

final class ConcreteNamespaceAdapterTest extends \PHPUnit_Framework_TestCase {
    private $base;
    private $namespace;
    private $all;
    private $adapter;
    public function setUp() {
        $this->base = [
            'Rodson'
        ];

        $this->namespace = [
            'Tests',
            'Tests',
            'Unit',
            'Adapters'
        ];

        $this->all = 'Rodson\Tests\Tests\Unit\Adapters';

        $this->adapter = new ConcreteNamespaceAdapter($this->base);
    }

    public function tearDown() {

    }

    public function testFromDataToNamespace_Success() {

        $namespace = $this->adapter->fromDataToNamespace($this->namespace);

        $this->assertEquals($this->all, $namespace->get());

    }

}
