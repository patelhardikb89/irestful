<?php
namespace iRESTful\Rodson\Classes\Domain\CustomMethods\SourceCodes\Adapters;

interface SourceCodeAdapter {
    public function fromSourceCodeLinesToSourceCode(array $lines);
}
