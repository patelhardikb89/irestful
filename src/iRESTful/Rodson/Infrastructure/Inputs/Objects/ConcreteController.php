<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Controller;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Exceptions\ControllerException;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Views\View;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\HttpRequest;

final class ConcreteController implements Controller {
    private $name;
    private $inputName;
    private $pattern;
    private $instructions;
    private $view;
    private $constants;
    private $httpRequests;
    public function __construct(
        $name,
        $inputName,
        $pattern,
        array $instructions,
        array $tests,
        View $view,
        array $constants = null,
        array $httpRequests = null
    ) {

        if (empty($constants)) {
            $constants = null;
        }

        if (empty($httpRequests)) {
            $httpRequests = null;
        }

        if (empty($pattern) || !is_string($pattern)) {
            throw new ControllerException('The pattern must be a non-empty string.');
        }

        if (empty($name) || !is_string($name)) {
            throw new ControllerException('The name must be a non-empty string.');
        }

        if (empty($inputName) || !is_string($inputName)) {
            throw new ControllerException('The inputName must be a non-empty string.');
        }

        if (empty($instructions)) {
            throw new ControllerException('There must be at least 1 instruction.');
        }

        if (empty($tests)) {
            throw new ControllerException('There must be at least 1 test.');
        }

        foreach($instructions as $index => $oneInstruction) {

            if (!is_integer($index)) {
                throw new ControllerException('The instructions must contain integer indexes.');
            }

            if (empty($oneInstruction) || !is_string($oneInstruction)) {
                throw new ControllerException('The instructions must be strings.');
            }

        }

        foreach($tests as $index => $oneTest) {

            if (!is_integer($index)) {
                throw new ControllerException('The tests must contain integer indexes.');
            }

            if (empty($oneTest) || !is_array($oneTest)) {
                throw new ControllerException('The tests must contain arrays.');
            }

            foreach($oneTest as $subIndex => $oneSubTest) {

                if (!is_integer($subIndex)) {
                    throw new ControllerException('The tests[] must contain integer indexes.');
                }

                if (empty($oneSubTest) || (!is_array($oneSubTest) && !is_string($oneSubTest))) {
                    throw new ControllerException('The tests[] must contain arrays and/or strings.');
                }

                if (is_array($oneSubTest)) {

                    foreach($oneSubTest as $subSubIndex => $oneSubSubTest) {

                        if (!is_integer($subSubIndex)) {
                            throw new ControllerException('The tests[][] must contain integer indexes.');
                        }

                        if (empty($oneSubSubTest) || (!is_array($oneSubSubTest) && !is_string($oneSubSubTest))) {
                            throw new ControllerException('The tests[][] must contain array and/or strings.');
                        }

                        if (is_array($oneSubSubTest)) {
                            foreach($oneSubSubTest as $subSubSubIndex => $oneSubSubSubTest) {

                                if (!is_integer($subSubSubIndex)) {
                                    throw new ControllerException('The tests[][][] must contain integer indexes.');
                                }

                                if (empty($oneSubSubSubTest) || !is_string($oneSubSubSubTest)) {
                                    throw new ControllerException('The tests[][] must contain strings.');
                                }

                            }
                        }
                    }
                }
            }

        }

        if (!empty($constants)) {
            foreach($constants as $keyname => $value) {

                if (!is_string($keyname)) {
                    throw new ControllerException('The constants array keynames must be strings.');
                }

                if (is_object($value)) {
                    throw new ControllerException('The constants array must contain strings and/or numeric values.');
                }

                if (is_array($value)) {
                    throw new ControllerException('The constants array must contain strings and/or numeric values.');
                }

            }
        }

        if (!empty($httpRequests)) {
            foreach($httpRequests as $oneHttpRequest) {
                if (!($oneHttpRequest instanceof HttpRequest)) {
                    throw new ControllerException('The httpRequests array must only contain HttpRequest objects.');
                }
            }
        }

        $this->name = $name;
        $this->inputName = $inputName;
        $this->pattern = $pattern;
        $this->instructions = $instructions;
        $this->tests = $tests;
        $this->view = $view;
        $this->constants = $constants;
        $this->httpRequests = $httpRequests;

    }

    public function getName() {
        return $this->name;
    }

    public function getInputName() {
        return $this->inputName;
    }

    public function getPattern() {
        return $this->pattern;
    }

    public function getInstructions() {
        return $this->instructions;
    }

    public function getTests() {
        return $this->tests;
    }

    public function getView() {
        return $this->view;
    }

    public function hasConstants() {
        return !empty($this->constants);
    }

    public function getConstants() {
        return $this->constants;
    }

    public function hasHttpRequests() {
        return !empty($this->httpRequests);
    }

    public function getHttpRequests() {
        return $this->httpRequests;
    }

}
