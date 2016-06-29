<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteAdapter;

final class ConcreteAdapterTest extends \PHPUnit_Framework_TestCase {
    private $typeMock;
    private $methodMock;
    public function setUp() {
        $this->typeMock = $this->getMock('iRESTful\Rodson\Domain\Types\Type');
        $this->methodMock = $this->getMock('iRESTful\Rodson\Domain\Codes\Methods\Method');
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $adapter = new ConcreteAdapter($this->typeMock, $this->typeMock, $this->methodMock);

        $this->assertEquals($this->typeMock, $adapter->fromType());
        $this->assertEquals($this->typeMock, $adapter->toType());
        $this->assertEquals($this->methodMock, $adapter->getMethod());

    }

}
