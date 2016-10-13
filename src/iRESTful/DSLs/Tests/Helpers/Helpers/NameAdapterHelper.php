<?php
namespace iRESTful\DSLs\Tests\Helpers\Adapters;
use iRESTful\DSLs\Domain\Names\Adapters\NameAdapter;
use iRESTful\DSLs\Domain\Names\Name;
use iRESTful\DSLs\Domain\Names\Exceptions\NameException;

final class NameAdapterHelper {
    private $phpunit;
    private $nameAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, NameAdapter $nameAdapterMock) {
        $this->phpunit = $phpunit;
        $this->nameAdapterMock = $nameAdapterMock;
    }

    public function expectsFromStringToName_Success(Name $returnedName, $string) {
        $this->nameAdapterMock->expects($this->phpunit->once())
                                ->method('fromStringToName')
                                ->with($string)
                                ->will($this->phpunit->returnValue($returnedName));
    }

    public function expectsFromStringToName_throwsNameException($string) {
        $this->nameAdapterMock->expects($this->phpunit->once())
                                ->method('fromStringToName')
                                ->with($string)
                                ->will($this->phpunit->throwException(new NameException('TEST')));
    }
}
