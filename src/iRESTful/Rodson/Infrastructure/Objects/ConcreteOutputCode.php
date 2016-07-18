<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Outputs\Codes\Code;
use iRESTful\Rodson\Domain\Outputs\Codes\Paths\Path;
use iRESTful\Rodson\Domain\Outputs\Codes\Exceptions\CodeException;

final class ConcreteOutputCode implements Code {
    private $code;
    private $path;
    private $subCodes;
    public function __construct($code, Path $path, array $subCodes = null) {

        if (empty($subCodes)) {
            $subCodes = null;
        }

        if (empty($code) || !is_string($code)) {
            throw new CodeException('The code must be a non-empty string.');
        }

        if (!empty($subCodes)) {
            foreach($subCodes as $oneSubCode) {
                if (!($oneSubCode instanceof Code)) {
                    throw new CodeException('The subCodes array must only contain Code objects.');
                }
            }
        }


        $this->code = $code;
        $this->path = $path;
        $this->subCodes = $subCodes;
    }

    public function getCode() {
        return $this->code;
    }

    public function getPath() {
        return $this->path;
    }

    public function hasSubCodes() {
        return !empty($this->subCodes);
    }

    public function getSubCodes() {
        return $this->subCodes;
    }

}
