<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Criterias\ControllerRuleCriteria;

final class ControllerRuleCriteriaHelper {
    private $phpunit;
    private $controllerRuleCriteriaMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ControllerRuleCriteria $controllerRuleCriteriaMock) {
        $this->phpunit = $phpunit;
        $this->controllerRuleCriteriaMock = $controllerRuleCriteriaMock;
    }

    public function expectsGetURI_Success($returnedURI) {
        $this->controllerRuleCriteriaMock->expects($this->phpunit->once())
                                            ->method('getURI')
                                            ->will($this->phpunit->returnValue($returnedURI));
    }

    public function expectsGetMethod_Success($returnedMethod) {
        $this->controllerRuleCriteriaMock->expects($this->phpunit->once())
                                            ->method('getMethod')
                                            ->will($this->phpunit->returnValue($returnedMethod));
    }

    public function expectsHasPort_Success($returnedBoolean) {
        $this->controllerRuleCriteriaMock->expects($this->phpunit->once())
                                            ->method('hasPort')
                                            ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetPort_Success($returnedPort) {
        $this->controllerRuleCriteriaMock->expects($this->phpunit->once())
                                            ->method('getPort')
                                            ->will($this->phpunit->returnValue($returnedPort));
    }

    public function expectsHasQueryParameters_Success($returnedBoolean) {
        $this->controllerRuleCriteriaMock->expects($this->phpunit->once())
                                            ->method('hasQueryParameters')
                                            ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetQueryParameters_Success(array $returnedQueryParameters) {
        $this->controllerRuleCriteriaMock->expects($this->phpunit->once())
                                            ->method('getQueryParameters')
                                            ->will($this->phpunit->returnValue($returnedQueryParameters));
    }

}
