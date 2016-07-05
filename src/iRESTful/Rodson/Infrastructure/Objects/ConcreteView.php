<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Inputs\Views\View;
use iRESTful\Rodson\Domain\Inputs\Codes\Methods\Method;
use iRESTful\Rodson\Domain\Inputs\Views\Exceptions\ViewException;

final class ConcreteView implements View {
    private $name;
    private $method;
    public function __construct($name, Method $method) {

        if (empty($name) || !is_string($name)) {
            throw new ViewException('The name must be a non-empty string.');
        }

        $this->name = $name;
        $this->method = $method;

    }

    public function getName() {
        return $this->name;
    }

    public function getMethod() {
        return $this->method;
    }

}
