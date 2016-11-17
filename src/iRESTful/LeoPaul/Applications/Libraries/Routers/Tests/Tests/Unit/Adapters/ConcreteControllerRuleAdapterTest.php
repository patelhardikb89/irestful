<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Tests\Unit\Adapters;
use  iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Adapters\ConcreteControllerRuleAdapter;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Adapters\ControllerRuleCriteriaAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Exceptions\ControllerRuleException;

final class ConcreteControllerRuleAdapterTest extends \PHPUnit_Framework_TestCase {
    private $controllerRuleCriteriaAdapterMock;
    private $controllerRuleCriteriaMock;
    private $controllerMock;
    private $criteria;
    private $data;
    private $adapter;
    private $controllerRuleCriteriaAdapterHelper;
    public function setUp() {
        $this->controllerRuleCriteriaAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Criterias\Adapters\ControllerRuleCriteriaAdapter');
        $this->controllerRuleCriteriaMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Criterias\ControllerRuleCriteria');
        $this->controllerMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller');

        $this->criteria = [
            'some' => 'criteria'
        ];

        $this->data = [
            'criteria' => $this->criteria,
            'controller' => $this->controllerMock
        ];

        $this->adapter = new ConcreteControllerRuleAdapter($this->controllerRuleCriteriaAdapterMock);

        $this->controllerRuleCriteriaAdapterHelper = new ControllerRuleCriteriaAdapterHelper($this, $this->controllerRuleCriteriaAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToControllerRule_Success() {

        $this->controllerRuleCriteriaAdapterHelper->expectsFromDataToControllerRuleCriteria_Success($this->controllerRuleCriteriaMock, $this->criteria);

        $rule = $this->adapter->fromDataToControllerRule($this->data);

        $this->assertEquals($this->controllerMock, $rule->getController());

    }

    public function testFromDataToControllerRule_throwsControllerRuleCriteriaException_throws() {

        $this->controllerRuleCriteriaAdapterHelper->expectsFromDataToControllerRuleCriteria_throwsControllerRuleCriteriaException($this->criteria);

        $asserted = false;
        try {

            $this->adapter->fromDataToControllerRule($this->data);

        } catch (ControllerRuleException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToControllerRule_withNonArrayCriteria_Success() {

        $this->data['criteria'] = new \DateTime();

        $asserted = false;
        try {

            $this->adapter->fromDataToControllerRule($this->data);

        } catch (ControllerRuleException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToControllerRule_withInvalidController_Success() {

        $this->data['controller'] = new \DateTime();

        $asserted = false;
        try {

            $this->adapter->fromDataToControllerRule($this->data);

        } catch (ControllerRuleException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToControllerRule_withoutCriteria_Success() {

        unset($this->data['criteria']);

        $asserted = false;
        try {

            $this->adapter->fromDataToControllerRule($this->data);

        } catch (ControllerRuleException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToControllerRule_withoutController_Success() {

        unset($this->data['controller']);

        $asserted = false;
        try {

            $this->adapter->fromDataToControllerRule($this->data);

        } catch (ControllerRuleException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToControllerRules_Success() {

        $this->controllerRuleCriteriaAdapterHelper->expectsFromDataToControllerRuleCriteria_Success($this->controllerRuleCriteriaMock, $this->criteria);

        $rules = $this->adapter->fromDataToControllerRules([$this->data]);

        $this->assertEquals(1, count($rules));
        $this->assertEquals($this->controllerMock, $rules[0]->getController());

    }

}
