<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\Adapters\MicroDateTimeClosureAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\MicroDateTimeClosure;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\Exceptions\MicroDateTimeClosureException;

final class MicroDateTimeClosureAdapterHelper {
    private $phpunit;
    private $microDateTimeClosureAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, MicroDateTimeClosureAdapter $microDateTimeClosureAdapterMock) {
        $this->phpunit = $phpunit;
        $this->microDateTimeClosureAdapterMock = $microDateTimeClosureAdapterMock;
    }

    public function expectsFromClosureToMicroDateTimeClosure_Success(MicroDateTimeClosure $returnedMicroDateTimeClosure, \Closure $closure) {
        $this->microDateTimeClosureAdapterMock->expects($this->phpunit->once())
                                                ->method('fromClosureToMicroDateTimeClosure')
                                                ->with($closure)
                                                ->will($this->phpunit->returnValue($returnedMicroDateTimeClosure));
    }

    public function expectsFromClosureToMicroDateTimeClosure_throwsMicroDateTimeClosureException(\Closure $closure) {
        $this->microDateTimeClosureAdapterMock->expects($this->phpunit->once())
                                                ->method('fromClosureToMicroDateTimeClosure')
                                                ->with($closure)
                                                ->will($this->phpunit->throwException(new MicroDateTimeClosureException('TEST')));
    }

}
