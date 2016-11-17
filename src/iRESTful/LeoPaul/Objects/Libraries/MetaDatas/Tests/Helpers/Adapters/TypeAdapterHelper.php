<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Adapters\TypeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Type;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Exceptions\TypeException;

final class TypeAdapterHelper {
    private $phpunit;
    private $typeAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, TypeAdapter $typeAdapterMock) {
        $this->phpunit = $phpunit;
        $this->typeAdapterMock = $typeAdapterMock;
    }

    public function expectsFromDataToType_Success(Type $returnedType, array $data) {
        $this->typeAdapterMock->expects($this->phpunit->once())
                                ->method('fromDataToType')
                                ->with($data)
                                ->will($this->phpunit->returnValue($returnedType));
    }

    public function expectsFromDataToType_throwsTypeException(array $data) {
        $this->typeAdapterMock->expects($this->phpunit->once())
                                ->method('fromDataToType')
                                ->with($data)
                                ->will($this->phpunit->throwException(new TypeException('TEST')));
    }

}
