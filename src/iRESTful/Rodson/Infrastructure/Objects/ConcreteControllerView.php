<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Controllers\Views\View;
use iRESTful\Rodson\Domain\Codes\Code;
use iRESTful\Rodson\Domain\Controllers\Views\Exceptions\ViewException;

final class ConcreteControllerView implements View {
    private $name;
    private $code;
    public function __construct($name, Code $code) {

        if (empty($name) || !is_string($name)) {
            throw new ViewException('The name must be a non-empty string.');
        }

        $this->name = $name;
        $this->code = $code;

    }

    public function getName() {
        return $this->name;
    }

    public function getCode() {
        return $this->code;
    }

}
