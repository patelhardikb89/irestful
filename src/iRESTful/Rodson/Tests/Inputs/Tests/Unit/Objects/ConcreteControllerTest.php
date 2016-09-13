<?php
namespace iRESTful\Rodson\Tests\Inputs\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteController;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Exceptions\ControllerException;

final class ConcreteControllerTest extends \PHPUnit_Framework_TestCase {
    private $viewMock;
    private $pattern;
    private $instructions;
    public function setUp() {
        $this->viewMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Projects\Views\View');

        $this->pattern = '/\/[a-zA-Z]+/s';

        $this->instructions = [
            'role = retrieve roles by uuid:input->uuid',
            'return convert role:role to data'
        ];
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $controller = new ConcreteController($this->pattern, $this->instructions, $this->viewMock);

        $this->assertEquals($this->pattern, $controller->getPattern());
        $this->assertEquals($this->instructions, $controller->getInstructions());
        $this->assertEquals($this->viewMock, $controller->getView());

    }

    public function testCreate_withInvalidIndexesInInstructions_throwsControllerException() {

        $asserted = false;
        try {

            new ConcreteController($this->pattern, ['some' => 'bad instructions'], $this->viewMock);

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withOneEmptyInstruction_throwsControllerException() {

        $this->instructions[] = '';

        $asserted = false;
        try {

            new ConcreteController($this->pattern, $this->instructions, $this->viewMock);

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withOneNonStringInstruction_throwsControllerException() {

        $this->instructions[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteController($this->pattern, $this->instructions, $this->viewMock);

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyInstructions_throwsControllerException() {

        $asserted = false;
        try {

            new ConcreteController($this->pattern, [], $this->viewMock);

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyPattern_throwsControllerException() {

        $asserted = false;
        try {

            new ConcreteController('', $this->instructions, $this->viewMock);

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringPattern_throwsControllerException() {

        $asserted = false;
        try {

            new ConcreteController(new \DateTime(), $this->instructions, $this->viewMock);

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
