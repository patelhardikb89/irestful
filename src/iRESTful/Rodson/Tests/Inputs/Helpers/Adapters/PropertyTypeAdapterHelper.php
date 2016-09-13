<?php
namespace iRESTful\Rodson\Tests\Inputs\Helpers\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Properties\Types\Adapters\TypeAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Properties\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Properties\Types\Exceptions\TypeException;

final class PropertyTypeAdapterHelper {
    private $phpunit;
    private $typeAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, TypeAdapter $typeAdapterMock) {
        $this->phpunit = $phpunit;
        $this->typeAdapterMock = $typeAdapterMock;
    }

    public function expectsFromStringToType_Success(Type $returnedType, $string) {
        $this->typeAdapterMock->expects($this->phpunit->once())
                                ->method('fromStringToType')
                                ->with($string)
                                ->will($this->phpunit->returnValue($returnedType));
    }

    public function expectsFromStringToType_throwsTypeException($string) {
        $this->typeAdapterMock->expects($this->phpunit->once())
                                ->method('fromStringToType')
                                ->with($string)
                                ->will($this->phpunit->throwException(new TypeException('TEST')));
    }

}
