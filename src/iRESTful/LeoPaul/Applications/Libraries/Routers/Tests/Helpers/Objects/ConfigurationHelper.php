<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Configs\Configuration;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;

final class ConfigurationHelper {
    private $phpunit;
    private $configurationMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, Configuration $configurationMock) {
        $this->phpunit = $phpunit;
        $this->configurationMock = $configurationMock;
    }

    public function expectsGetControllerRules_Success(array $returnedRules) {
        $this->configurationMock->expects($this->phpunit->once())
                                ->method('getControllerRules')
                                ->will($this->phpunit->returnValue($returnedRules));
    }

    public function expectsHasNotFoundController_Success($returnedBoolean) {
        $this->configurationMock->expects($this->phpunit->once())
                                ->method('hasNotFoundController')
                                ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetNotFoundController_Success(Controller $returnedController) {
        $this->configurationMock->expects($this->phpunit->once())
                                ->method('getNotFoundController')
                                ->will($this->phpunit->returnValue($returnedController));
    }

}
