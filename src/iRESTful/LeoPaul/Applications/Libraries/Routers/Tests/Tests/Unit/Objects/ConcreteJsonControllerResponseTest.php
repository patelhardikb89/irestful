<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Objects\ConcreteJsonControllerResponse;

final class ConcreteJsonControllerResponseTest extends \PHPUnit_Framework_TestCase {
    private $data;
    public function setUp() {
        $this->data = [
            'some' => 'data'
        ];
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $response = new ConcreteJsonControllerResponse($this->data);

        $this->assertEquals(['Content-Type: application/json'], $response->getHeaders());
        $this->assertTrue($response->hasOutput());
        $this->assertEquals('{"some":"data"}', $response->getOutput());

    }

    public function testCreate_withEmptyData_Success() {

        $response = new ConcreteJsonControllerResponse([]);

        $this->assertEquals(['Content-Type: application/json'], $response->getHeaders());
        $this->assertTrue($response->hasOutput());
        $this->assertEquals('[]', $response->getOutput());

    }

    public function testCreate_withoutData_Success() {

        $response = new ConcreteJsonControllerResponse();

        $this->assertEquals(['Content-Type: application/json'], $response->getHeaders());
        $this->assertTrue($response->hasOutput());
        $this->assertEquals('[]', $response->getOutput());

    }

}
