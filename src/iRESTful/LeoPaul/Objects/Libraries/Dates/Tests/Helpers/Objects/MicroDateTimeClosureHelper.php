<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\MicroDateTimeClosure;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\MicroDateTime;

final class MicroDateTimeClosureHelper {
    private $phpunit;
    private $microDateTimeClosureMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, MicroDateTimeClosure $microDateTimeClosureMock) {
        $this->phpunit = $phpunit;
        $this->microDateTimeClosureMock = $microDateTimeClosureMock;
    }

    public function expectsGetClosure_Success(\Closure $returnedClosure) {
        $this->microDateTimeClosureMock->expects($this->phpunit->once())
                                        ->method('getClosure')
                                        ->will($this->phpunit->returnValue($returnedClosure));
    }

    public function expectsStartedOn_Success(MicroDateTime $returnedMicroDateTime) {
        $this->microDateTimeClosureMock->expects($this->phpunit->once())
                                        ->method('startedOn')
                                        ->will($this->phpunit->returnValue($returnedMicroDateTime));
    }

    public function expectsEndsOn_Success(MicroDateTime $returnedMicroDateTime) {
        $this->microDateTimeClosureMock->expects($this->phpunit->once())
                                        ->method('endsOn')
                                        ->will($this->phpunit->returnValue($returnedMicroDateTime));
    }

    public function expectsHasResults_Success($returnedBoolean) {
        $this->microDateTimeClosureMock->expects($this->phpunit->once())
                                        ->method('hasResults')
                                        ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetResults_Success($returnedResults) {
        $this->microDateTimeClosureMock->expects($this->phpunit->once())
                                        ->method('getResults')
                                        ->will($this->phpunit->returnValue($returnedResults));
    }

}
