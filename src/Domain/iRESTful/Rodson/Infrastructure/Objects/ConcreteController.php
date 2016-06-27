<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Controllers\Controller;
use iRESTful\Rodson\Domain\Controllers\Views\View;
use iRESTful\Rodson\Domain\Controllers\Exceptions\ControllerException;

final class ConcreteController implements Controller {
    private $pattern;
    private $instructions;
    private $view;
    public function __construct($pattern, array $instructions, View $view) {

        if (empty($pattern) || !is_string($pattern)) {
            throw new ControllerException('The pattern must be a non-empty string.');
        }

        foreach($instructions as $index => $oneInstruction) {

            if (!is_integer($index)) {
                throw new ControllerException('The instructions must contain integer indexes.');
            }

            if (!is_string($oneInstruction)) {
                throw new ControllerException('The instructions must be strings.');
            }

        }

        $this->pattern = $pattern;
        $this->instructions = $instructions;
        $this->view = $view;

    }

    public function getPattern() {
        return $this->pattern;
    }

    public function getInstructions() {
        return $this->instructions;
    }

    public function getView() {
        return $this->view;
    }

}
