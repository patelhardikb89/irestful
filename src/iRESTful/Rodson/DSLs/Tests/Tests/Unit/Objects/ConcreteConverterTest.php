<?php
namespace iRESTful\Rodson\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteConverter;
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Exceptions\ConverterException;

final class ConcreteConverterTest extends \PHPUnit_Framework_TestCase {
    private $typeMock;
    private $methodMock;
    public function setUp() {
        $this->typeMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\Projects\Converters\Types\Type');
    }

    public function tearDown() {

    }

    public function testCreate_hasFromType_Success() {

        $adapter = new ConcreteConverter($this->typeMock);

        $this->assertTrue($adapter->hasFromType());
        $this->assertEquals($this->typeMock, $adapter->fromType());
        $this->assertFalse($adapter->hasToType());
        $this->assertNull($adapter->toType());


    }

    public function testCreate_hasToType_Success() {

        $adapter = new ConcreteConverter(null, $this->typeMock);

        $this->assertFalse($adapter->hasFromType());
        $this->assertNull($adapter->fromType());
        $this->assertTrue($adapter->hasToType());
        $this->assertEquals($this->typeMock, $adapter->toType());

    }

    public function testCreate_Success() {

        $adapter = new ConcreteConverter($this->typeMock, $this->typeMock);

        $this->assertTrue($adapter->hasFromType());
        $this->assertEquals($this->typeMock, $adapter->fromType());
        $this->assertTrue($adapter->hasToType());
        $this->assertEquals($this->typeMock, $adapter->toType());

    }

    public function testCreate_withoutTypes_throwsConverterException() {

        $asserted = false;
        try {

            new ConcreteConverter();

        } catch (ConverterException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
