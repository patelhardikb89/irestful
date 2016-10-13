<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteDatabaseTypeBinary;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Binaries\Exceptions\BinaryException;

final class ConcreteDatabaseTypeBinaryTest extends \PHPUnit_Framework_TestCase {
    private $specificBitSize;
    private $maxBitSize;
    public function setUp() {

        $this->specificBitSize = rand(1, 500);
        $this->maxBitSize = rand(1, 500);

    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $binary = new ConcreteDatabaseTypeBinary();

        $this->assertFalse($binary->hasSpecificBitSize());
        $this->assertNull($binary->getSpecificBitSize());
        $this->assertFalse($binary->hasMaxBitSize());
        $this->assertNull($binary->getMaxBitSize());

    }

    public function testCreate_withSpecificBitSize_Success() {

        $binary = new ConcreteDatabaseTypeBinary($this->specificBitSize);

        $this->assertTrue($binary->hasSpecificBitSize());
        $this->assertEquals($this->specificBitSize, $binary->getSpecificBitSize());
        $this->assertFalse($binary->hasMaxBitSize());
        $this->assertNull($binary->getMaxBitSize());

    }

    public function testCreate_withMaxBitSize_Success() {

        $binary = new ConcreteDatabaseTypeBinary(null, $this->maxBitSize);

        $this->assertFalse($binary->hasSpecificBitSize());
        $this->assertNull($binary->getSpecificBitSize());
        $this->assertTrue($binary->hasMaxBitSize());
        $this->assertEquals($this->maxBitSize, $binary->getMaxBitSize());

    }

    public function testCreate_withSpecificBitSize_withMaxBitSize_Success() {

        $asserted = false;
        try {

            new ConcreteDatabaseTypeBinary($this->specificBitSize, $this->maxBitSize);

        } catch (BinaryException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withZeroSpecificBitSize_throwsBinaryException() {

        $asserted = false;
        try {

            new ConcreteDatabaseTypeBinary(0);

        } catch (BinaryException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withZeroMaxBitSize_throwsBinaryException() {

        $asserted = false;
        try {

            new ConcreteDatabaseTypeBinary(null, 0);

        } catch (BinaryException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNegativeSpecificBitSize_throwsBinaryException() {

        $asserted = false;
        try {

            new ConcreteDatabaseTypeBinary($this->specificBitSize * -1);

        } catch (BinaryException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNegativeZeroMaxBitSize_throwsBinaryException() {

        $asserted = false;
        try {

            new ConcreteDatabaseTypeBinary(null, $this->maxBitSize * -1);

        } catch (BinaryException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
