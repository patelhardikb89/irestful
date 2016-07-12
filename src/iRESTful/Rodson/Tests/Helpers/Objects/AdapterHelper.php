<?php
namespace iRESTful\Rodson\Tests\Helpers\Objects;
use iRESTful\Rodson\Domain\Inputs\Adapters\Adapter;
use iRESTful\Rodson\Domain\Inputs\Types\Type;

final class AdapterHelper {
    private $phpunit;
    private $adapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, Adapter $adapterMock) {
        $this->phpunit = $phpunit;
        $this->adapterMock = $adapterMock;
    }

    public function expectsHasFromType_Success($returnedBoolean) {
        $this->adapterMock->expects($this->phpunit->once())
                            ->method('hasFromType')
                            ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsFromType_Success(Type $returnedType) {
        $this->adapterMock->expects($this->phpunit->once())
                            ->method('fromType')
                            ->will($this->phpunit->returnValue($returnedType));
    }

    public function expectsHasToType_Success($returnedBoolean) {
        $this->adapterMock->expects($this->phpunit->once())
                            ->method('hasToType')
                            ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsToType_Success(Type $returnedType) {
        $this->adapterMock->expects($this->phpunit->once())
                            ->method('toType')
                            ->will($this->phpunit->returnValue($returnedType));
    }

}
