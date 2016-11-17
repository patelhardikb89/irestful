<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Type;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Binaries\BinaryType;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Floats\FloatType;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Integers\IntegerType;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Strings\StringType;

final class TypeHelper {
    private $phpunit;
    private $typeMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, Type $typeMock) {
        $this->phpunit = $phpunit;
        $this->typeMock = $typeMock;
    }

    public function expectsHasBinary_Success($returnedBoolean) {
        $this->typeMock->expects($this->phpunit->once())
                        ->method('hasBinary')
                        ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetBinary_Success(BinaryType $returnedBinary) {
        $this->typeMock->expects($this->phpunit->once())
                        ->method('getBinary')
                        ->will($this->phpunit->returnValue($returnedBinary));
    }

    public function expectsHasInteger_Success($returnedBoolean) {
        $this->typeMock->expects($this->phpunit->once())
                        ->method('hasInteger')
                        ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetInteger_Success(IntegerType $returnedInteger) {
        $this->typeMock->expects($this->phpunit->once())
                        ->method('getInteger')
                        ->will($this->phpunit->returnValue($returnedInteger));
    }

    public function expectsHasFloat_Success($returnedBoolean) {
        $this->typeMock->expects($this->phpunit->once())
                        ->method('hasFloat')
                        ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetFloat_Success(FloatType $returnedFloat) {
        $this->typeMock->expects($this->phpunit->once())
                        ->method('getFloat')
                        ->will($this->phpunit->returnValue($returnedFloat));
    }

    public function expectsHasString_Success($returnedBoolean) {
        $this->typeMock->expects($this->phpunit->once())
                        ->method('hasString')
                        ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetString_Success(StringType $returnedString) {
        $this->typeMock->expects($this->phpunit->once())
                        ->method('getString')
                        ->will($this->phpunit->returnValue($returnedString));
    }

}
