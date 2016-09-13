<?php
namespace iRESTful\Rodson\Tests\Inputs\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteDatabaseTypeString;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Strings\Exceptions\StringException;

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

        $binary = new ConcreteDatabaseTypeString();

        $this->assertFalse($binary->hasSpecificCharacterSize());
        $this->assertNull($binary->getSpecificCharacterSize());
        $this->assertFalse($binary->hasMaxCharacterSize());
        $this->assertNull($binary->getMaxCharacterSize());

    }

    public function testCreate_withSpecificCharacterSize_Success() {

        $binary = new ConcreteDatabaseTypeString($this->specificCharacterSize);

        $this->assertTrue($binary->hasSpecificCharacterSize());
        $this->assertEquals($this->specificCharacterSize, $binary->getSpecificCharacterSize());
        $this->assertFalse($binary->hasMaxCharacterSize());
        $this->assertNull($binary->getMaxCharacterSize());

    }

    public function testCreate_withMaximumCharacterSize_Success() {

        $binary = new ConcreteDatabaseTypeString(null, $this->maximumCharacterSize);

        $this->assertFalse($binary->hasSpecificCharacterSize());
        $this->assertNull($binary->getSpecificCharacterSize());
        $this->assertTrue($binary->hasMaxCharacterSize());
        $this->assertEquals($this->maximumCharacterSize, $binary->getMaxCharacterSize());

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

    public function testCreate_withStringSpecificCharacterSize_throwsStringException() {

        $asserted = false;
        try {

            new ConcreteDatabaseTypeString('9');

        } catch (StringException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withStringZeroMaximumCharacterSize_throwsStringException() {

        $asserted = false;
        try {

            new ConcreteDatabaseTypeString(null, '8');

        } catch (StringException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonIntegerSpecificCharacterSize_throwsStringException() {

        $asserted = false;
        try {

            new ConcreteDatabaseTypeString(new \DateTime());

        } catch (StringException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonIntegerZeroMaximumCharacterSize_throwsStringException() {

        $asserted = false;
        try {

            new ConcreteDatabaseTypeString(null, new \DateTime());

        } catch (StringException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
