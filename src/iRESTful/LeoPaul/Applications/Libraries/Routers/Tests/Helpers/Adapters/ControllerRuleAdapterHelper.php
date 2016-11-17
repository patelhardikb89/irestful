<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Adapters\ControllerRuleAdapter;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Exceptions\ControllerRuleException;

final class ControllerRuleAdapterHelper {
    private $phpunit;
    private $controllerRuleAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ControllerRuleAdapter $controllerRuleAdapterMock) {
        $this->phpunit = $phpunit;
        $this->controllerRuleAdapterMock = $controllerRuleAdapterMock;
    }

    public function expectsFromDataToControllerRules_Success(array $returnedRules, array $data) {
        $this->controllerRuleAdapterMock->expects($this->phpunit->once())
                                        ->method('fromDataToControllerRules')
                                        ->with($data)
                                        ->will($this->phpunit->returnValue($returnedRules));
    }

    public function expectsFromDataToControllerRules_throwsControllerRuleException(array $data) {
        $this->controllerRuleAdapterMock->expects($this->phpunit->once())
                                        ->method('fromDataToControllerRules')
                                        ->with($data)
                                        ->will($this->phpunit->throwException(new ControllerRuleException('TEST')));
    }

}
