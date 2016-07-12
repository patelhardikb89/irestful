<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Outputs\Codes\Code;
use iRESTful\Rodson\Domain\Outputs\Codes\Paths\Path;
use iRESTful\Rodson\Domain\Outputs\Codes\Exceptions\CodeException;

final class ConcreteOutputCode implements Code {
    private $code;
    private $path;
    public function __construct($code, Path $path) {

        if (empty($code) || !is_string($code)) {
            throw new CodeException('The code must be a non-empty string.');
        }

        $this->code = $code;
        $this->path = $path;
    }

    public function getCode() {
        return $this->code;
    }

    public function getPath() {
        return $this->path;
    }

}
