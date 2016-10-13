<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteType;
use iRESTful\DSLs\Domain\Projects\Types\Exceptions\TypeException;

final class ConcreteTypeTest extends \PHPUnit_Framework_TestCase {
    private $databaseTypeMock;
    private $converterMock;
    private $methodMock;
    private $name;
    public function setUp() {
        $this->databaseTypeMock = $this->createMock('iRESTful\DSLs\Domain\Projects\Types\Databases\DatabaseType');
        $this->converterMock = $this->createMock('iRESTful\DSLs\Domain\Projects\Converters\Converter');
        $this->methodMock = $this->createMock('iRESTful\DSLs\Domain\Projects\Codes\Methods\Method');

        $this->name = 'MyType';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $type = new ConcreteType($this->name, $this->databaseTypeMock, $this->converterMock);

        $this->assertEquals($this->name, $type->getName());
        $this->assertEquals($this->databaseTypeMock, $type->getDatabaseType());
        $this->assertEquals($this->converterMock, $type->getDatabaseConverter());
        $this->assertFalse($type->hasViewConverter());
        $this->assertNull($type->getViewConverter());
        $this->assertFalse($type->hasMethod());
        $this->assertNull($type->getMethod());

    }

    public function testCreate_withViewAdapter_Success() {

        $type = new ConcreteType($this->name, $this->databaseTypeMock, $this->converterMock, $this->converterMock);

        $this->assertEquals($this->name, $type->getName());
        $this->assertEquals($this->databaseTypeMock, $type->getDatabaseType());
        $this->assertEquals($this->converterMock, $type->getDatabaseConverter());
        $this->assertTrue($type->hasViewConverter());
        $this->assertEquals($this->converterMock, $type->getViewConverter());
        $this->assertFalse($type->hasMethod());
        $this->assertNull($type->getMethod());

    }

    public function testCreate_withMethod_Success() {

        $type = new ConcreteType($this->name, $this->databaseTypeMock, $this->converterMock, null, $this->methodMock);

        $this->assertEquals($this->name, $type->getName());
        $this->assertEquals($this->databaseTypeMock, $type->getDatabaseType());
        $this->assertEquals($this->converterMock, $type->getDatabaseConverter());
        $this->assertFalse($type->hasViewConverter());
        $this->assertNull($type->getViewConverter());
        $this->assertTrue($type->hasMethod());
        $this->assertEquals($this->methodMock, $type->getMethod());

    }

    public function testCreate_withViewAdapter_withMethod_Success() {

        $type = new ConcreteType($this->name, $this->databaseTypeMock, $this->converterMock, $this->converterMock, $this->methodMock);

        $this->assertEquals($this->name, $type->getName());
        $this->assertEquals($this->databaseTypeMock, $type->getDatabaseType());
        $this->assertEquals($this->converterMock, $type->getDatabaseConverter());
        $this->assertTrue($type->hasViewConverter());
        $this->assertEquals($this->converterMock, $type->getViewConverter());
        $this->assertTrue($type->hasMethod());
        $this->assertEquals($this->methodMock, $type->getMethod());

    }

    public function testCreate_withEmptyName_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteType('', $this->databaseTypeMock, $this->converterMock);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
