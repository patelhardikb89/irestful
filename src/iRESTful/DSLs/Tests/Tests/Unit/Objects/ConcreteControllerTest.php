<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteController;
use iRESTful\DSLs\Domain\Projects\Controllers\Exceptions\ControllerException;

final class ConcreteControllerTest extends \PHPUnit_Framework_TestCase {
    private $viewMock;
    private $httpRequestMock;
    private $name;
    private $inputName;
    private $pattern;
    private $instructions;
    private $tests;
    private $constants;
    private $httpRequests;
    public function setUp() {
        $this->viewMock = $this->createMock('iRESTful\DSLs\Domain\Projects\Controllers\Views\View');
        $this->httpRequestMock = $this->createMock('iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\HttpRequest');

        $this->name = 'my_controller';
        $this->inputName = 'input';
        $this->pattern = '/\/[a-zA-Z]+/s';

        $this->instructions = [
            'role = retrieve roles by uuid:input->uuid',
            'return convert role:role to data'
        ];

        $this->constants = [
            'some' => 'constants',
            'another' => rand(1, 500),
            'just_another' => (float) (rand(1, 500) / 32)
        ];

        $this->httpRequests = [
            $this->httpRequestMock,
            $this->httpRequestMock
        ];

        $this->tests = [
            [
                'some tests',
                [
                    'one sub test',
                    'another sub test',
                    [
                        'last test',
                        'or another last test'
                    ]
                ]
            ]
        ];
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $controller = new ConcreteController(
            $this->name,
            $this->inputName,
            $this->pattern,
            $this->instructions,
            $this->tests,
            $this->viewMock
        );

        $this->assertEquals($this->name, $controller->getName());
        $this->assertEquals($this->inputName, $controller->getInputName());
        $this->assertEquals($this->pattern, $controller->getPattern());
        $this->assertEquals($this->instructions, $controller->getInstructions());
        $this->assertEquals($this->tests, $controller->getTests());
        $this->assertEquals($this->viewMock, $controller->getView());
        $this->assertFalse($controller->hasConstants());
        $this->assertNull($controller->getConstants());
        $this->assertFalse($controller->hasHttpRequests());
        $this->assertNull($controller->getHttpRequests());

    }

    public function testCreate_withConstants_Success() {

        $controller = new ConcreteController(
            $this->name,
            $this->inputName,
            $this->pattern,
            $this->instructions,
            $this->tests,
            $this->viewMock,
            $this->constants
        );

        $this->assertEquals($this->name, $controller->getName());
        $this->assertEquals($this->inputName, $controller->getInputName());
        $this->assertEquals($this->pattern, $controller->getPattern());
        $this->assertEquals($this->instructions, $controller->getInstructions());
        $this->assertEquals($this->tests, $controller->getTests());
        $this->assertEquals($this->viewMock, $controller->getView());
        $this->assertTrue($controller->hasConstants());
        $this->assertEquals($this->constants, $controller->getConstants());
        $this->assertFalse($controller->hasHttpRequests());
        $this->assertNull($controller->getHttpRequests());

    }

    public function testCreate_withHttpRequests_Success() {

        $controller = new ConcreteController(
            $this->name,
            $this->inputName,
            $this->pattern,
            $this->instructions,
            $this->tests,
            $this->viewMock,
            null,
            $this->httpRequests
        );

        $this->assertEquals($this->name, $controller->getName());
        $this->assertEquals($this->inputName, $controller->getInputName());
        $this->assertEquals($this->pattern, $controller->getPattern());
        $this->assertEquals($this->instructions, $controller->getInstructions());
        $this->assertEquals($this->tests, $controller->getTests());
        $this->assertEquals($this->viewMock, $controller->getView());
        $this->assertFalse($controller->hasConstants());
        $this->assertNull($controller->getConstants());
        $this->assertTrue($controller->hasHttpRequests());
        $this->assertEquals($this->httpRequests, $controller->getHttpRequests());

    }

    public function testCreate_withConstants_withHttpRequests_Success() {

        $controller = new ConcreteController(
            $this->name,
            $this->inputName,
            $this->pattern,
            $this->instructions,
            $this->tests,
            $this->viewMock,
            $this->constants,
            $this->httpRequests
        );

        $this->assertEquals($this->name, $controller->getName());
        $this->assertEquals($this->inputName, $controller->getInputName());
        $this->assertEquals($this->pattern, $controller->getPattern());
        $this->assertEquals($this->instructions, $controller->getInstructions());
        $this->assertEquals($this->tests, $controller->getTests());
        $this->assertEquals($this->viewMock, $controller->getView());
        $this->assertTrue($controller->hasConstants());
        $this->assertEquals($this->constants, $controller->getConstants());
        $this->assertTrue($controller->hasHttpRequests());
        $this->assertEquals($this->httpRequests, $controller->getHttpRequests());

    }

    public function testCreate_withEmptyName_throwsControllerException() {

        $asserted = false;
        try {

            new ConcreteController(
                '',
                $this->inputName,
                $this->pattern,
                $this->instructions,
                $this->tests,
                $this->viewMock
            );

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyInputName_throwsControllerException() {

        $asserted = false;
        try {

            new ConcreteController(
                $this->name,
                '',
                $this->pattern,
                $this->instructions,
                $this->tests,
                $this->viewMock
            );

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyPattern_throwsControllerException() {

        $asserted = false;
        try {

            new ConcreteController(
                $this->name,
                $this->inputName,
                '',
                $this->instructions,
                $this->tests,
                $this->viewMock
            );

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyInstructions_throwsControllerException() {

        $asserted = false;
        try {

            new ConcreteController(
                $this->name,
                $this->inputName,
                $this->pattern,
                [],
                $this->tests,
                $this->viewMock
            );

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyTests_throwsControllerException() {

        $asserted = false;
        try {

            new ConcreteController(
                $this->name,
                $this->inputName,
                $this->pattern,
                $this->instructions,
                [],
                $this->viewMock
            );

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withStringKeynameInInstructions_throwsControllerException() {

        $instructions = [
            'some' => 'instructions'
        ];

        $asserted = false;
        try {

            new ConcreteController(
                $this->name,
                $this->inputName,
                $this->pattern,
                $instructions,
                $this->tests,
                $this->viewMock
            );

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringInstructions_throwsControllerException() {

        $instructions = [
            [
                'some instructions'
            ]
        ];

        $asserted = false;
        try {

            new ConcreteController(
                $this->name,
                $this->inputName,
                $this->pattern,
                $instructions,
                $this->tests,
                $this->viewMock
            );

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withConstants_invalidKeyname_throwsControllerException() {

        $constants = [
            'one_constant'
        ];

        $asserted = false;
        try {

            new ConcreteController(
                $this->name,
                $this->inputName,
                $this->pattern,
                $this->instructions,
                $this->tests,
                $this->viewMock,
                $constants
            );

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withConstants_withObjectAsConstant_throwsControllerException() {

        $constants = [
            'one_constant' => new \DateTime()
        ];

        $asserted = false;
        try {

            new ConcreteController(
                $this->name,
                $this->inputName,
                $this->pattern,
                $this->instructions,
                $this->tests,
                $this->viewMock,
                $constants
            );

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withConstants_withArrayAsConstant_throwsControllerException() {

        $constants = [
            'one_constant' => [
                'one' => 'array'
            ]
        ];

        $asserted = false;
        try {

            new ConcreteController(
                $this->name,
                $this->inputName,
                $this->pattern,
                $this->instructions,
                $this->tests,
                $this->viewMock,
                $constants
            );

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withHttpRequests_withOneInvalidHttpRequest_throwsControllerException() {

        $this->httpRequests[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteController(
                $this->name,
                $this->inputName,
                $this->pattern,
                $this->instructions,
                $this->tests,
                $this->viewMock,
                null,
                $this->httpRequests
            );

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withTest_withInvalidKeynames_inFirstDepth_throwsControllerException() {

        $tests = [
            'some_tests' => [
                'first'
            ]
        ];

        $asserted = false;
        try {

            new ConcreteController(
                $this->name,
                $this->inputName,
                $this->pattern,
                $this->instructions,
                $tests,
                $this->viewMock
            );

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withTest_withInvalidValue_inFirstDepth_throwsControllerException() {

        $tests = [
            'first test'
        ];

        $asserted = false;
        try {

            new ConcreteController(
                $this->name,
                $this->inputName,
                $this->pattern,
                $this->instructions,
                $tests,
                $this->viewMock
            );

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withTest_withInvalidKeynames_inSecondDepth_throwsControllerException() {

        $tests = [
            [
                'some' => [
                    'tests'
                ]
            ]
        ];

        $asserted = false;
        try {

            new ConcreteController(
                $this->name,
                $this->inputName,
                $this->pattern,
                $this->instructions,
                $tests,
                $this->viewMock
            );

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withTest_withInvalidValue_inSecondDepth_throwsControllerException() {

        $tests = [
            [
                rand(1, 500)
            ]
        ];

        $asserted = false;
        try {

            new ConcreteController(
                $this->name,
                $this->inputName,
                $this->pattern,
                $this->instructions,
                $tests,
                $this->viewMock
            );

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withTest_withInvalidKeynames_inThirdDepth_throwsControllerException() {

        $tests = [
            [
                [
                    'some' => [
                        'tests'
                    ]
                ]
            ]
        ];

        $asserted = false;
        try {

            new ConcreteController(
                $this->name,
                $this->inputName,
                $this->pattern,
                $this->instructions,
                $tests,
                $this->viewMock
            );

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withTest_withInvalidValue_inThirdDepth_throwsControllerException() {

        $tests = [
            [
                [
                    rand(1, 500)
                ]
            ]
        ];

        $asserted = false;
        try {

            new ConcreteController(
                $this->name,
                $this->inputName,
                $this->pattern,
                $this->instructions,
                $tests,
                $this->viewMock
            );

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withTest_withInvalidKeynames_inFourthDepth_throwsControllerException() {

        $tests = [
            [
                [
                    [
                        'some' => 'tests'
                    ]
                ]
            ]
        ];

        $asserted = false;
        try {

            new ConcreteController(
                $this->name,
                $this->inputName,
                $this->pattern,
                $this->instructions,
                $tests,
                $this->viewMock
            );

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withTest_withInvalidValue_inFourthDepth_throwsControllerException() {

        $tests = [
            [
                [
                    [
                        'some' => [
                            'just invalid'
                        ]
                    ]
                ]
            ]
        ];

        $asserted = false;
        try {

            new ConcreteController(
                $this->name,
                $this->inputName,
                $this->pattern,
                $this->instructions,
                $tests,
                $this->viewMock
            );

        } catch (ControllerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
