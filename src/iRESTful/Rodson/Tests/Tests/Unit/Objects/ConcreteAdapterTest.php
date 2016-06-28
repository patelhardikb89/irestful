<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteAdapter;

final class ConcreteAdapterTest extends \PHPUnit_Framework_TestCase {
    private $typeMock;
    private $codeMock;
    public function setUp() {
        $this->typeMock = $this->getMock('iRESTful\Rodson\Domain\Types\Type');
        $this->codeMock = $this->getMock('iRESTful\Rodson\Domain\Codes\Code');
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $adapter = new ConcreteAdapter($this->typeMock, $this->typeMock, $this->codeMock);

        $this->assertEquals($this->typeMock, $adapter->fromType());
        $this->assertEquals($this->typeMock, $adapter->toType());
        $this->assertEquals($this->codeMock, $adapter->getCode());

    }

}
