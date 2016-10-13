<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteDatabaseTypeString;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Strings\Exceptions\StringException;

final class ConcreteDatabaseTypeStringTest extends \PHPUnit_Framework_TestCase {
    private $specificCharacterSize;
    private $maximumCharacterSize;
    public function setUp() {
        $this->specificCharacterSize = rand(1, 500);
        $this->maximumCharacterSize = rand(1, 500);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $string = new ConcreteDatabaseTypeString();

        $this->assertFalse($string->hasSpecificCharacterSize());
        $this->assertNull($string->getSpecificCharacterSize());
        $this->assertFalse($string->hasMaxCharacterSize());
        $this->assertNull($string->getMaxCharacterSize());

    }

    public function testCreate_withSpecificCharacterSize_Success() {

        $string = new ConcreteDatabaseTypeString($this->specificCharacterSize);

        $this->assertTrue($string->hasSpecificCharacterSize());
        $this->assertEquals($this->specificCharacterSize, $string->getSpecificCharacterSize());
        $this->assertFalse($string->hasMaxCharacterSize());
        $this->assertNull($string->getMaxCharacterSize());

    }

    public function testCreate_withMaximumCharacterSize_Success() {

        $string = new ConcreteDatabaseTypeString(null, $this->maximumCharacterSize);

        $this->assertFalse($string->hasSpecificCharacterSize());
        $this->assertNull($string->getSpecificCharacterSize());
        $this->assertTrue($string->hasMaxCharacterSize());
        $this->assertEquals($this->maximumCharacterSize, $string->getMaxCharacterSize());

    }

    public function testCreate_withSpecificCharacterSize_withMaximumCharacterSize_Success() {

        $asserted = false;
        try {

            new ConcreteDatabaseTypeString($this->specificCharacterSize, $this->maximumCharacterSize);

        } catch (StringException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withZeroSpecificCharacterSize_throwsStringException() {

        $asserted = false;
        try {

            new ConcreteDatabaseTypeString(0);

        } catch (StringException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withZeroMaximumCharacterSize_throwsStringException() {

        $asserted = false;
        try {

            new ConcreteDatabaseTypeString(null, 0);

        } catch (StringException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNegativeSpecificCharacterSize_throwsStringException() {

        $asserted = false;
        try {

            new ConcreteDatabaseTypeString($this->specificCharacterSize * -1);

        } catch (StringException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNegativeZeroMaximumCharacterSize_throwsStringException() {

        $asserted = false;
        try {

            new ConcreteDatabaseTypeString(null, $this->maximumCharacterSize * -1);

        } catch (StringException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
