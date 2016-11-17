<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Objects\ConcreteConfiguration;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Configs\Exceptions\ConfigurationException;

final class ConcreteConfigurationTest extends \PHPUnit_Framework_TestCase {
    private $controllerRuleMock;
    private $controllerMock;
    private $rules;
    public function setUp() {
        $this->controllerRuleMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\ControllerRule');
        $this->controllerMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller');

        $this->rules = [
            $this->controllerRuleMock,
            $this->controllerRuleMock
        ];
    }

    public function tearDown() {

    }

    public function testCreateConfiguration_Succss() {

        $configuration = new ConcreteConfiguration($this->rules);

        $this->assertEquals($this->rules, $configuration->getControllerRules());
        $this->assertFalse($configuration->hasNotFoundController());
        $this->assertNull($configuration->getNotFoundController());

    }

    public function testCreateConfiguration_withoutRules_Succss() {

        $configuration = new ConcreteConfiguration([]);

        $this->assertEquals([], $configuration->getControllerRules());
        $this->assertFalse($configuration->hasNotFoundController());
        $this->assertNull($configuration->getNotFoundController());

    }

    public function testCreateConfiguration_withNotFoundController_Succss() {

        $configuration = new ConcreteConfiguration($this->rules, $this->controllerMock);

        $this->assertEquals($this->rules, $configuration->getControllerRules());
        $this->assertTrue($configuration->hasNotFoundController());
        $this->assertEquals($this->controllerMock, $configuration->getNotFoundController());

    }

    public function testCreateConfiguration_withOneInvalidRule_Succss() {

        $this->rules[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteConfiguration($this->rules);

        } catch (ConfigurationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
