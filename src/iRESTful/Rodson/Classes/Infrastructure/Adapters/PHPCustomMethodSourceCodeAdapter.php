<?php
namespace iRESTful\Rodson\Classes\Infrastructure\Adapters;
use iRESTful\Rodson\Classes\Domain\CustomMethods\SourceCodes\Adapters\SourceCodeAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Objects\ConcreteCustomMethodSourceCode;

final class PHPCustomMethodSourceCodeAdapter implements SourceCodeAdapter {

    public function __construct() {

    }

    public function fromSourceCodeLinesToSourceCode(array $lines) {
        return new ConcreteCustomMethodSourceCode($lines);
    }

}
