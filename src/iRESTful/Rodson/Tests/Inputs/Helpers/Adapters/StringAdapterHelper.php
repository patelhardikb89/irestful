<?php
namespace iRESTful\Rodson\Tests\Inputs\Helpers\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Strings\Adapters\StringAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Strings\String;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Strings\Exceptions\StringException;

final class StringAdapterHelper {
    private $phpunit;
    private $stringAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, StringAdapter $stringAdapterMock) {
        $this->phpunit = $phpunit;
        $this->stringAdapterMock = $stringAdapterMock;
    }

    public function expectsFromDataToString_Success(String $returnedString, array $data) {
        $this->stringAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToString')
                                    ->with($data)
                                    ->will($this->phpunit->returnValue($returnedString));
    }

    public function expectsFromDataToString_throwsStringException(array $data) {
        $this->stringAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToString')
                                    ->with($data)
                                    ->will($this->phpunit->throwException(new StringException('TEST')));
    }

}
