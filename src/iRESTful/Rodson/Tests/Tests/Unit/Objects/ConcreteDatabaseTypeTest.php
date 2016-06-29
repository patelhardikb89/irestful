<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteDatabaseType;
use iRESTful\Rodson\Domain\Types\Databases\Exceptions\DatabaseTypeException;

final class ConcreteDatabaseTypeTest extends \PHPUnit_Framework_TestCase {
    private $binaryMock;
    private $floatMock;
    private $integerMock;
    private $stringMock;
    private $name;
    public function setUp() {
        $this->binaryMock = $this->getMock('iRESTful\Rodson\Domain\Types\Databases\Binaries\Binary');
        $this->floatMock = $this->getMock('iRESTful\Rodson\Domain\Types\Databases\Floats\Float');
        $this->integerMock = $this->getMock('iRESTful\Rodson\Domain\Types\Databases\Integers\Integer');
        $this->stringMock = $this->getMock('iRESTful\Rodson\Domain\Types\Databases\Strings\String');

        $this->name = 'some_name';
    }

    public function tearDown() {

    }

    public function testCreate_withBinary_Success() {

        $type = new ConcreteDatabaseType($this->name, false, $this->binaryMock);

        $this->assertEquals($this->name, $type->getName());
        $this->assertFalse($type->hasBoolean());
        $this->assertTrue($type->hasBinary());
        $this->assertEquals($this->binaryMock, $type->getBinary());
        $this->assertFalse($type->hasFloat());
        $this->assertNull($type->getFloat());
        $this->assertFalse($type->hasInteger());
        $this->assertNull($type->getInteger());
        $this->assertFalse($type->hasString());
        $this->assertNull($type->getString());

    }

    public function testCreate_withFloat_Success() {

        $type = new ConcreteDatabaseType($this->name, false, null, $this->floatMock);

        $this->assertEquals($this->name, $type->getName());
        $this->assertFalse($type->hasBoolean());
        $this->assertFalse($type->hasBinary());
        $this->assertNull($type->getBinary());
        $this->assertTrue($type->hasFloat());
        $this->assertEquals($this->floatMock, $type->getFloat());
        $this->assertFalse($type->hasInteger());
        $this->assertNull($type->getInteger());
        $this->assertFalse($type->hasString());
        $this->assertNull($type->getString());

    }

    public function testCreate_withInteger_Success() {

        $type = new ConcreteDatabaseType($this->name, false, null, null, $this->integerMock);

        $this->assertEquals($this->name, $type->getName());
        $this->assertFalse($type->hasBoolean());
        $this->assertFalse($type->hasBinary());
        $this->assertNull($type->getBinary());
        $this->assertFalse($type->hasFloat());
        $this->assertNull($type->getFloat());
        $this->assertTrue($type->hasInteger());
        $this->assertEquals($this->integerMock, $type->getInteger());
        $this->assertFalse($type->hasString());
        $this->assertNull($type->getString());

    }

    public function testCreate_withString_Success() {

        $type = new ConcreteDatabaseType($this->name, false, null, null, null, $this->stringMock);

        $this->assertEquals($this->name, $type->getName());
        $this->assertFalse($type->hasBoolean());
        $this->assertFalse($type->hasBinary());
        $this->assertNull($type->getBinary());
        $this->assertFalse($type->hasFloat());
        $this->assertNull($type->getFloat());
        $this->assertFalse($type->hasInteger());
        $this->assertNull($type->getInteger());
        $this->assertTrue($type->hasString());
        $this->assertEquals($this->stringMock, $type->getString());

    }

    public function testCreate_withBoolean_Success() {

        $type = new ConcreteDatabaseType($this->name, true);

        $this->assertEquals($this->name, $type->getName());
        $this->assertTrue($type->hasBoolean());
        $this->assertFalse($type->hasBinary());
        $this->assertNull($type->getBinary());
        $this->assertFalse($type->hasFloat());
        $this->assertNull($type->getFloat());
        $this->assertFalse($type->hasInteger());
        $this->assertNull($type->getInteger());
        $this->assertFalse($type->hasString());
        $this->assertNull($type->getString());

    }

    public function testCreate_withTooManyTypes_throwsDatabaseTypeException() {

        $asserted = false;
        try {

            new ConcreteDatabaseType($this->name, true, $this->binaryMock, $this->floatMock, $this->integerMock, $this->stringMock);

        } catch (DatabaseTypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withoutType_throwsDatabaseTypeException() {

        $asserted = false;
        try {

            new ConcreteDatabaseType($this->name, false);

        } catch (DatabaseTypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyName_throwsDatabaseTypeException() {

        $asserted = false;
        try {

            new ConcreteDatabaseType('', false);

        } catch (DatabaseTypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsDatabaseTypeException() {

        $asserted = false;
        try {

            new ConcreteDatabaseType(new \DateTime(), false);

        } catch (DatabaseTypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonBooleanHasBoolean_throwsDatabaseTypeException() {

        $asserted = false;
        try {

            new ConcreteDatabaseType($this->name, new \DateTime());

        } catch (DatabaseTypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
