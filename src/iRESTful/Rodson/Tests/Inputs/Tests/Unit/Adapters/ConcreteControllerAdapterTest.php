<?php
namespace iRESTful\Rodson\Tests\Inputs\Tests\Unit\Adapters;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteControllerAdapter;
use iRESTful\Rodson\Domain\Inputs\Controllers\Exceptions\ControllerException;

final class ConcreteControllerAdapterTest extends \PHPUnit_Framework_TestCase {
    private $viewMock;
    private $views;
    private $pattern;
    private $instructions;
    private $data;
    private $multipleData;
    private $adapter;
    public function setUp() {
        $this->viewMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Views\View');

        $this->views = [
            'json' => $this->viewMock
        ];

        $this->pattern = '/\/[a-z]+/s';
        $this->instructions = [
            'some instructions'
        ];

        $this->data = [
            'pattern' => $this->pattern,
            'view' => 'json',
            'instructions' => $this->instructions
        ];

        $this->multipleData = [
            $this->pattern => [
                'view' => 'json',
                'instructions' => $this->instructions
            ]
        ];

        $this->adapter = new ConcreteControllerAdapter($this->views);
    }

    public function tearDown() {

    }

    public function testFromDataToController_Success() {

        $controller = $this->adapter->fromDataToController($this->data);

        $this->assertEquals($this->pattern, $controller->getPattern());
        $this->assertEquals($this->instructions, $controller->getInstructions());
        $this->assertEquals($this->viewMock, $controller->getView());

    }

    public function testFromDataToController_withViewNameNotFoundInViews_throwsControllerException() {

        $this->data['view'] = 'invalid_view';

        $asserted = false;
        try {

            $this->adapter->fromDataToController($this->data);

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToController_withoutInstructions_throwsControllerException() {

        unset($this->data['instructions']);

        $asserted = false;
        try {

            $this->adapter->fromDataToController($this->data);

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToController_withoutView_throwsControllerException() {

        unset($this->data['view']);

        $asserted = false;
        try {

            $this->adapter->fromDataToController($this->data);

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToController_withoutPattern_throwsControllerException() {

        unset($this->data['pattern']);

        $asserted = false;
        try {

            $this->adapter->fromDataToController($this->data);

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToControllers_Success() {

        $controllers = $this->adapter->fromDataToControllers($this->multipleData);

        $this->assertEquals($this->pattern, $controllers[0]->getPattern());
        $this->assertEquals($this->instructions, $controllers[0]->getInstructions());
        $this->assertEquals($this->viewMock, $controllers[0]->getView());

    }

}
