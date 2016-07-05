<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Outputs\Codes\Code;

final class ConcreteOutputCode implements Code {
    private $code;
    private $path;
    public function __construct($code, array $path) {
        $this->code = $code;
        $this->path = $path;
    }

    public function getCode() {
        return $this->code;
    }

    public function getRelativeFilePath() {
        return $this->path;
    }

}
