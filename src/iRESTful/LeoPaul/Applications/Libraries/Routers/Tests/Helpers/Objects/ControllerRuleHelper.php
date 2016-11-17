<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\ControllerRule;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;

final class ControllerRuleHelper {
    private $phpunit;
    private $controllerRuleMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ControllerRule $controllerRuleMock) {
        $this->phpunit = $phpunit;
        $this->controllerRuleMock = $controllerRuleMock;
    }

    public function expectsMatch_Success($returnedBoolean) {
        $this->controllerRuleMock->expects($this->phpunit->once())
                                    ->method('match')
                                    ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetController_Success(Controller $returnedController) {
        $this->controllerRuleMock->expects($this->phpunit->once())
                                    ->method('getController')
                                    ->will($this->phpunit->returnValue($returnedController));
    }

}
