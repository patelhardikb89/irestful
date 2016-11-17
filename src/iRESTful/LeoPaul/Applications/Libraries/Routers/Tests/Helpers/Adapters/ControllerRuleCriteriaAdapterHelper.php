<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Criterias\Adapters\ControllerRuleCriteriaAdapter;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Criterias\Exceptions\ControllerRuleCriteriaException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Criterias\ControllerRuleCriteria;

final class ControllerRuleCriteriaAdapterHelper {
    private $phpunit;
    private $controllerRuleCriteriaAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ControllerRuleCriteriaAdapter $controllerRuleCriteriaAdapterMock) {
        $this->phpunit = $phpunit;
        $this->controllerRuleCriteriaAdapterMock = $controllerRuleCriteriaAdapterMock;
    }

    public function expectsFromDataToControllerRuleCriteria_Success(ControllerRuleCriteria $returnedCriteria, array $data) {
        $this->controllerRuleCriteriaAdapterMock->expects($this->phpunit->once())
                                                ->method('fromDataToControllerRuleCriteria')
                                                ->with($data)
                                                ->will($this->phpunit->returnValue($returnedCriteria));
    }

    public function expectsFromDataToControllerRuleCriteria_throwsControllerRuleCriteriaException(array $data) {
        $this->controllerRuleCriteriaAdapterMock->expects($this->phpunit->once())
                                                ->method('fromDataToControllerRuleCriteria')
                                                ->with($data)
                                                ->will($this->phpunit->throwException(new ControllerRuleCriteriaException('TEST')));
    }

}
