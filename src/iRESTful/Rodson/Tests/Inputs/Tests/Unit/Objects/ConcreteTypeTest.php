<?php
namespace iRESTful\Rodson\Tests\Inputs\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteType;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Exceptions\TypeException;

final class ConcreteTypeTest extends \PHPUnit_Framework_TestCase {
    private $databaseTypeMock;
    private $adapterMock;
    private $methodMock;
    private $name;
    public function setUp() {
        $this->databaseTypeMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\DatabaseType');
        $this->adapterMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Projects\Converters\Adapter');
        $this->methodMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Projects\Codes\Methods\Method');

        $this->name = 'MyType';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $type = new ConcreteType($this->name, $this->databaseTypeMock, $this->adapterMock);

        $this->assertEquals($this->name, $type->getName());
        $this->assertEquals($this->databaseTypeMock, $type->getDatabaseType());
        $this->assertEquals($this->adapterMock, $type->getDatabaseAdapter());
        $this->assertFalse($type->hasViewAdapter());
        $this->assertNull($type->getViewAdapter());
        $this->assertFalse($type->hasMethod());
        $this->assertNull($type->getMethod());

    }

    public function testCreate_withViewAdapter_Success() {

        $type = new ConcreteType($this->name, $this->databaseTypeMock, $this->adapterMock, $this->adapterMock);

        $this->assertEquals($this->name, $type->getName());
        $this->assertEquals($this->databaseTypeMock, $type->getDatabaseType());
        $this->assertEquals($this->adapterMock, $type->getDatabaseAdapter());
        $this->assertTrue($type->hasViewAdapter());
        $this->assertEquals($this->adapterMock, $type->getViewAdapter());
        $this->assertFalse($type->hasMethod());
        $this->assertNull($type->getMethod());

    }

    public function testCreate_withMethod_Success() {

        $type = new ConcreteType($this->name, $this->databaseTypeMock, $this->adapterMock, null, $this->methodMock);

        $this->assertEquals($this->name, $type->getName());
        $this->assertEquals($this->databaseTypeMock, $type->getDatabaseType());
        $this->assertEquals($this->adapterMock, $type->getDatabaseAdapter());
        $this->assertFalse($type->hasViewAdapter());
        $this->assertNull($type->getViewAdapter());
        $this->assertTrue($type->hasMethod());
        $this->assertEquals($this->methodMock, $type->getMethod());

    }

    public function testCreate_withViewAdapter_withMethod_Success() {

        $type = new ConcreteType($this->name, $this->databaseTypeMock, $this->adapterMock, $this->adapterMock, $this->methodMock);

        $this->assertEquals($this->name, $type->getName());
        $this->assertEquals($this->databaseTypeMock, $type->getDatabaseType());
        $this->assertEquals($this->adapterMock, $type->getDatabaseAdapter());
        $this->assertTrue($type->hasViewAdapter());
        $this->assertEquals($this->adapterMock, $type->getViewAdapter());
        $this->assertTrue($type->hasMethod());
        $this->assertEquals($this->methodMock, $type->getMethod());

    }

    public function testCreate_withEmptyName_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteType('', $this->databaseTypeMock);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteType(new \DateTime(), $this->databaseTypeMock);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
