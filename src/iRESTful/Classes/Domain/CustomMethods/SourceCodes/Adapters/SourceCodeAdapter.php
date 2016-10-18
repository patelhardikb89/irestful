<?php
namespace iRESTful\Classes\Domain\CustomMethods\SourceCodes\Adapters;

interface SourceCodeAdapter {
    public function fromInstructionsToControllerSourceCode(array $instructions);
    public function fromInstructionsToSourceCode(array $instructions);
    public function fromDataToSourceCode(array $data);
    public function fromSourceCodeLinesToSourceCode(array $lines);
}
