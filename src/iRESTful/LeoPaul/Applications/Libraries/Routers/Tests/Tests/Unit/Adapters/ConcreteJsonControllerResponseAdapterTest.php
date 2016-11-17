<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Adapters\ConcreteJsonControllerResponseAdapter;

final class ConcreteJsonControllerResponseAdapterTest extends \PHPUnit_Framework_TestCase {
    private $data;
    private $adapter;
    public function setUp() {
        $this->data = [
            'some' => 'data'
        ];

        $this->adapter = new ConcreteJsonControllerResponseAdapter();
    }

    public function tearDown() {

    }

    public function testFromDataToControllerResponse_Success() {

        $response = $this->adapter->fromDataToControllerResponse($this->data);

        $this->assertEquals(['Content-Type: application/json'], $response->getHeaders());
        $this->assertEquals('{"some":"data"}', $response->getOutput());

    }

}
