<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Adapters;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteDatabaseTypeAdapter;
use iRESTful\Rodson\Tests\Helpers\Adapters\BinaryAdapterHelper;
use iRESTful\Rodson\Tests\Helpers\Adapters\FloatAdapterHelper;
use iRESTful\Rodson\Tests\Helpers\Adapters\IntegerAdapterHelper;
use iRESTful\Rodson\Tests\Helpers\Adapters\StringAdapterHelper;
use iRESTful\Rodson\Domain\Types\Databases\Exceptions\DatabaseTypeException;

final class ConcreteDatabaseTypeAdapterTest extends \PHPUnit_Framework_TestCase {
    private $binaryAdapterMock;
    private $binaryMock;
    private $floatAdapterMock;
    private $floatMock;
    private $integerAdapterMock;
    private $integerMock;
    private $stringAdapterMock;
    private $stringMock;
    private $dataWithBinary;
    private $dataWithFloat;
    private $dataWithInteger;
    private $dataWithString;
    private $dataWithBoolean;
    private $adapter;
    private $binaryAdapterHelper;
    private $floatAdapterHelper;
    private $integerAdapterHelper;
    private $stringAdapterHelper;
    public function setUp() {
        $this->binaryAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Types\Databases\Binaries\Adapters\BinaryAdapter');
        $this->binaryMock = $this->getMock('iRESTful\Rodson\Domain\Types\Databases\Binaries\Binary');
        $this->floatAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Types\Databases\Floats\Adapters\FloatAdapter');
        $this->floatMock = $this->getMock('iRESTful\Rodson\Domain\Types\Databases\Floats\Float');
        $this->integerAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Types\Databases\Integers\Adapters\IntegerAdapter');
        $this->integerMock = $this->getMock('iRESTful\Rodson\Domain\Types\Databases\Integers\Integer');
        $this->stringAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Types\Databases\Strings\Adapters\StringAdapter');
        $this->stringMock = $this->getMock('iRESTful\Rodson\Domain\Types\Databases\Strings\String');

        $this->dataWithBinary = [
            'name' => 'binary',
            'some' => 'data'
        ];

        $this->dataWithFloat = [
            'name' => 'float',
            'some' => 'data'
        ];

        $this->dataWithInteger = [
            'name' => 'integer',
            'some' => 'data'
        ];

        $this->dataWithString = [
            'name' => 'string',
            'some' => 'data'
        ];

        $this->dataWithBoolean = [
            'name' => 'boolean'
        ];

        $this->adapter = new ConcreteDatabaseTypeAdapter($this->binaryAdapterMock, $this->floatAdapterMock, $this->integerAdapterMock, $this->stringAdapterMock);

        $this->binaryAdapterHelper = new BinaryAdapterHelper($this, $this->binaryAdapterMock);
        $this->floatAdapterHelper = new FloatAdapterHelper($this, $this->floatAdapterMock);
        $this->integerAdapterHelper = new IntegerAdapterHelper($this, $this->integerAdapterMock);
        $this->stringAdapterHelper = new StringAdapterHelper($this, $this->stringAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToDatabaseType_withBoolean_Success() {

        $type = $this->adapter->fromDataToDatabaseType($this->dataWithBoolean);

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

    public function testFromDataToDatabaseType_withBinary_Success() {

        $this->binaryAdapterHelper->expectsFromDataToBinary_Success($this->binaryMock, $this->dataWithBinary);

        $type = $this->adapter->fromDataToDatabaseType($this->dataWithBinary);

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

    public function testFromDataToDatabaseType_withBinary_throwsBinaryException_throwsDatabaseTypeException() {

        $this->binaryAdapterHelper->expectsFromDataToBinary_throwsBinaryException($this->dataWithBinary);

        $asserted = false;
        try {

            $this->adapter->fromDataToDatabaseType($this->dataWithBinary);

        } catch (DatabaseTypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToDatabaseType_withFloat_Success() {

        $this->floatAdapterHelper->expectsFromDataToFloat_Success($this->floatMock, $this->dataWithFloat);

        $type = $this->adapter->fromDataToDatabaseType($this->dataWithFloat);

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

    public function testFromDataToDatabaseType_withFloat_throwsFloatException_throwsDatabaseTypeException() {

        $this->floatAdapterHelper->expectsFromDataToFloat_throwsFloatException($this->dataWithFloat);

        $asserted = false;
        try {

            $this->adapter->fromDataToDatabaseType($this->dataWithFloat);

        } catch (DatabaseTypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToDatabaseType_withInteger_Success() {

        $this->integerAdapterHelper->expectsFromDataToInteger_Success($this->integerMock, $this->dataWithInteger);

        $type = $this->adapter->fromDataToDatabaseType($this->dataWithInteger);

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

    public function testFromDataToDatabaseType_withInteger_throwsIntegerException_throwsDatabaseTypeException() {

        $this->integerAdapterHelper->expectsFromDataToInteger_throwsIntegerException($this->dataWithInteger);

        $asserted = false;
        try {

            $this->adapter->fromDataToDatabaseType($this->dataWithInteger);

        } catch (DatabaseTypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToDatabaseType_withString_Success() {

        $this->stringAdapterHelper->expectsFromDataToString_Success($this->stringMock, $this->dataWithString);

        $type = $this->adapter->fromDataToDatabaseType($this->dataWithString);

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

    public function testFromDataToDatabaseType_withString_throwsthrowsStringException_throwsDatabaseTypeException() {

        $this->stringAdapterHelper->expectsFromDataToString_throwsStringException($this->dataWithString);

        $asserted = false;
        try {

            $this->adapter->fromDataToDatabaseType($this->dataWithString);

        } catch (DatabaseTypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToDatabaseType_withoutName_throwsDatabaseTypeException() {

        unset($this->dataWithString['name']);

        $asserted = false;
        try {

            $this->adapter->fromDataToDatabaseType($this->dataWithString);

        } catch (DatabaseTypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
