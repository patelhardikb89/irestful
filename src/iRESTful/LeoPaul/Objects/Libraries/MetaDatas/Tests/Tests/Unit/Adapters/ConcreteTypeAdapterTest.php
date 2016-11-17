<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteTypeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Exceptions\TypeException;

final class ConcreteTypeAdapterTest extends \PHPUnit_Framework_TestCase {
    private $dataWithBinary;
    private $dataWithString;
    private $dataWithFloat;
    private $dataWithInteger;
    private $adapter;
    public function setUp() {

        $this->dataWithBinary = [
            'name' => 'binary',
            'specific_bit_size' => rand(1, 500),
            'max_bit_size' => rand(1, 200)
        ];

        $this->dataWithString = [
            'name' => 'string',
            'specific_character_size' => rand(1, 500),
            'max_character_size' => rand(1, 200)
        ];

        $this->dataWithFloat = [
            'name' => 'float',
            'digits_amount' => rand(1, 500),
            'precision' => rand(1, 200)
        ];

        $this->dataWithInteger = [
            'name' => 'integer',
            'max_bit_size' => rand(1, 500)
        ];

        $this->adapter = new ConcreteTypeAdapter();

    }

    public function tearDown() {

    }

    public function testFromDataToType_withBinary_withSpecificBitSize_Success() {

        unset($this->dataWithBinary['max_bit_size']);

        $type = $this->adapter->fromDataToType($this->dataWithBinary);

        $this->assertTrue($type->hasBinary());
        $this->assertEquals($this->dataWithBinary['specific_bit_size'], $type->getBinary()->getSpecificBitSize());
        $this->assertNull($type->getBinary()->getMaxBitSize());

    }

    public function testFromDataToType_withBinary_withMaxBitSize_Success() {

        unset($this->dataWithBinary['specific_bit_size']);

        $type = $this->adapter->fromDataToType($this->dataWithBinary);

        $this->assertTrue($type->hasBinary());
        $this->assertNull($type->getBinary()->getSpecificBitSize());
        $this->assertEquals($this->dataWithBinary['max_bit_size'], $type->getBinary()->getMaxBitSize());

    }

    public function testFromDataToType_withBinary_withSpecificBitSize_withMaxBitSize_throwsTypeException() {

        $asserted = false;
        try {

            $this->adapter->fromDataToType($this->dataWithBinary);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToType_withString_withSpecificCharacterSize_Success() {

        unset($this->dataWithString['max_character_size']);

        $type = $this->adapter->fromDataToType($this->dataWithString);

        $this->assertTrue($type->hasString());
        $this->assertEquals($this->dataWithString['specific_character_size'], $type->getString()->getSpecificCharacterSize());
        $this->assertNull($type->getString()->getMaxCharacterSize());

    }

    public function testFromDataToType_withString_withMaxCharacterSize_Success() {

        unset($this->dataWithString['specific_character_size']);

        $type = $this->adapter->fromDataToType($this->dataWithString);

        $this->assertTrue($type->hasString());
        $this->assertNull($type->getString()->getSpecificCharacterSize());
        $this->assertEquals($this->dataWithString['max_character_size'], $type->getString()->getMaxCharacterSize());

    }

    public function testFromDataToType_withString_withSpecificCharacterSize_withMaxCharacterSize_throwsTypeException() {

        $asserted = false;
        try {

            $this->adapter->fromDataToType($this->dataWithString);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToType_withFloat_Success() {

        $type = $this->adapter->fromDataToType($this->dataWithFloat);

        $this->assertTrue($type->hasFloat());
        $this->assertEquals($this->dataWithFloat['digits_amount'], $type->getFloat()->getDigitsAmount());
        $this->assertEquals($this->dataWithFloat['precision'], $type->getFloat()->getPrecision());
    }

    public function testFromDataToType_withFloat_withoutDigitsAmount_throwsTypeException() {

        unset($this->dataWithFloat['digits_amount']);

        $asserted = false;
        try {

            $this->adapter->fromDataToType($this->dataWithFloat);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToType_withFloat_withoutPrecision_throwsTypeException() {

        unset($this->dataWithFloat['precision']);

        $asserted = false;
        try {

            $this->adapter->fromDataToType($this->dataWithFloat);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToType_withInteger_Success() {

        $type = $this->adapter->fromDataToType($this->dataWithInteger);

        $this->assertTrue($type->hasInteger());
        $this->assertEquals($this->dataWithInteger['max_bit_size'], $type->getInteger()->getMaximumBitSize());
    }

    public function testFromDataToType_withInteger_withoutMaxBitSize_throwsTypeException() {

        unset($this->dataWithInteger['max_bit_size']);

        $asserted = false;
        try {

            $this->adapter->fromDataToType($this->dataWithInteger);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToType_withInvalidName_throwsTypeException() {

        $this->dataWithInteger['name'] = 'invalid_type';

        $asserted = false;
        try {

            $this->adapter->fromDataToType($this->dataWithInteger);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToType_withoutName_throwsTypeException() {

        unset($this->dataWithInteger['name']);

        $asserted = false;
        try {

            $this->adapter->fromDataToType($this->dataWithInteger);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
