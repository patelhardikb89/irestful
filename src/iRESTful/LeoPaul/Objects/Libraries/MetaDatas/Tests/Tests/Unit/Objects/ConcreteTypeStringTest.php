<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteTypeString;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Exceptions\TypeException;

final class ConcreteTypeStringTest extends \PHPUnit_Framework_TestCase {
    private $specificCharacterSize;
    private $maximumCharacterSize;
    public function setUp() {
        $this->specificCharacterSize = rand(1, 500);
        $this->maximumCharacterSize = rand(1, 500);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $binary = new ConcreteTypeString();

        $this->assertFalse($binary->hasSpecificCharacterSize());
        $this->assertNull($binary->getSpecificCharacterSize());
        $this->assertFalse($binary->hasMaxCharacterSize());
        $this->assertNull($binary->getMaxCharacterSize());

    }

    public function testCreate_withSpecificCharacterSize_Success() {

        $binary = new ConcreteTypeString($this->specificCharacterSize);

        $this->assertTrue($binary->hasSpecificCharacterSize());
        $this->assertEquals($this->specificCharacterSize, $binary->getSpecificCharacterSize());
        $this->assertFalse($binary->hasMaxCharacterSize());
        $this->assertNull($binary->getMaxCharacterSize());

    }

    public function testCreate_withMaximumCharacterSize_Success() {

        $binary = new ConcreteTypeString(null, $this->maximumCharacterSize);

        $this->assertFalse($binary->hasSpecificCharacterSize());
        $this->assertNull($binary->getSpecificCharacterSize());
        $this->assertTrue($binary->hasMaxCharacterSize());
        $this->assertEquals($this->maximumCharacterSize, $binary->getMaxCharacterSize());

    }

    public function testCreate_withSpecificCharacterSize_withMaximumCharacterSize_Success() {

        $asserted = false;
        try {

            new ConcreteTypeString($this->specificCharacterSize, $this->maximumCharacterSize);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withZeroSpecificCharacterSize_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeString(0);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withZeroMaximumCharacterSize_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeString(null, 0);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNegativeSpecificCharacterSize_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeString($this->specificCharacterSize * -1);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNegativeZeroMaximumCharacterSize_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeString(null, $this->maximumCharacterSize * -1);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withStringSpecificCharacterSize_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeString('9');

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withStringZeroMaximumCharacterSize_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeString(null, '8');

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonIntegerSpecificCharacterSize_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeString(new \DateTime());

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonIntegerZeroMaximumCharacterSize_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeString(null, new \DateTime());

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
