<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Adapters\ConcreteConfigurationAdapter;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Adapters\ControllerRuleAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Configs\Exceptions\ConfigurationException;

final class ConcreteConfigurationAdapterTest extends \PHPUnit_Framework_TestCase {
    private $controllerRuleAdapterMock;
    private $controllerRuleMock;
    private $controllerMock;
    private $rules;
    private $rulesCriterias;
    private $data;
    private $dataWithNotFoundController;
    private $adapter;
    private $controllerRuleAdapterHelper;
    public function setUp() {
        $this->controllerRuleAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Adapters\ControllerRuleAdapter');
        $this->controllerRuleMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\ControllerRule');
        $this->controllerMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller');

        $this->rules = [
            $this->controllerRuleMock,
            $this->controllerRuleMock
        ];

        $this->rulesCriterias = [
            'some' => 'rules'
        ];

        $this->data = [
            'rules' => $this->rulesCriterias
        ];

        $this->dataWithNotFoundController = [
            'rules' => $this->rulesCriterias,
            'not_found' => $this->controllerMock
        ];

        $this->adapter = new ConcreteConfigurationAdapter($this->controllerRuleAdapterMock);

        $this->controllerRuleAdapterHelper = new ControllerRuleAdapterHelper($this, $this->controllerRuleAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToConfiguration_Success() {

        $this->controllerRuleAdapterHelper->expectsFromDataToControllerRules_Success($this->rules, $this->rulesCriterias);

        $configuration = $this->adapter->fromDataToConfiguration($this->data);

        $this->assertEquals($this->rules, $configuration->getControllerRules());
        $this->assertFalse($configuration->hasNotFoundController());
        $this->assertNull($configuration->getNotFoundController());
    }

    public function testFromDataToConfiguration_withNotFoundController_Success() {

        $this->controllerRuleAdapterHelper->expectsFromDataToControllerRules_Success($this->rules, $this->rulesCriterias);

        $configuration = $this->adapter->fromDataToConfiguration($this->dataWithNotFoundController);

        $this->assertEquals($this->rules, $configuration->getControllerRules());
        $this->assertTrue($configuration->hasNotFoundController());
        $this->assertEquals($this->controllerMock, $configuration->getNotFoundController());
    }

    public function testFromDataToConfiguration_withNotFoundController_throwsControllerRuleException_throwsConfigurationException() {

        $this->controllerRuleAdapterHelper->expectsFromDataToControllerRules_throwsControllerRuleException($this->rulesCriterias);

        $asserted = false;
        try {

            $this->adapter->fromDataToConfiguration($this->dataWithNotFoundController);

        } catch (ConfigurationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToConfiguration_withInvalidNotFoundException_throwsConfigurationException() {

        $this->dataWithNotFoundController['not_found'] = new \DateTime();

        $asserted = false;
        try {

            $this->adapter->fromDataToConfiguration($this->dataWithNotFoundController);

        } catch (ConfigurationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToConfiguration_withInvalidRules_throwsConfigurationException() {

        $this->dataWithNotFoundController['rules'] = new \DateTime();

        $asserted = false;
        try {

            $this->adapter->fromDataToConfiguration($this->dataWithNotFoundController);

        } catch (ConfigurationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
