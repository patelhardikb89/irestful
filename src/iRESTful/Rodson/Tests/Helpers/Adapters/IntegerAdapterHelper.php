<?php
namespace iRESTful\Rodson\Tests\Helpers\Adapters;
use iRESTful\Rodson\Domain\Types\Databases\Integers\Adapters\IntegerAdapter;
use iRESTful\Rodson\Domain\Types\Databases\Integers\Integer;
use iRESTful\Rodson\Domain\Types\Databases\Integers\Exceptions\IntegerException;

final class IntegerAdapterHelper {
    private $phpunit;
    private $integerAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, IntegerAdapter $integerAdapterMock) {
        $this->phpunit = $phpunit;
        $this->integerAdapterMock = $integerAdapterMock;
    }

    public function expectsFromDataToInteger_Success(Integer $returnedInteger, array $data) {
        $this->integerAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToInteger')
                                    ->with($data)
                                    ->will($this->phpunit->returnvalue($returnedInteger));
    }

    public function expectsFromDataToInteger_throwsIntegerException(array $data) {
        $this->integerAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToInteger')
                                    ->with($data)
                                    ->will($this->phpunit->throwException(new IntegerException('TEST')));
    }

}
