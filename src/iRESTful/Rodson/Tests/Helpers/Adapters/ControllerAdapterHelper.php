<?php
namespace iRESTful\Rodson\Tests\Helpers\Adapters;
use iRESTful\Rodson\Domain\Inputs\Controllers\Adapters\ControllerAdapter;
use iRESTful\Rodson\Domain\Inputs\Controllers\Exceptions\ControllerException;

final class ControllerAdapterHelper {
    private $phpunit;
    private $controllerAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ControllerAdapter $controllerAdapterMock) {
        $this->phpunit = $phpunit;
        $this->controllerAdapterMock = $controllerAdapterMock;
    }

    public function expectsFromDataToControllers_Success(array $returnedControllers, array $data) {
        $this->controllerAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToControllers')
                                    ->with($data)
                                    ->will($this->phpunit->returnValue($returnedControllers));
    }

    public function expectsFromDataToControllers_multiple_Success(array $returnedControllers, array $data) {
        $amount = count($returnedControllers);
        $this->controllerAdapterMock->expects($this->phpunit->exactly($amount))
                                    ->method('fromDataToControllers')
                                    ->with(call_user_func_array(array($this->phpunit, 'logicalOr'), $data))
                                    ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedControllers));
    }

    public function expectsFromDataToControllers_throwsControllerException(array $data) {
        $this->controllerAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToControllers')
                                    ->with($data)
                                    ->will($this->phpunit->throwException(new ControllerException('TEST')));
    }

}
