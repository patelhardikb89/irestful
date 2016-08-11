<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Instructions\Adapters;

interface InstructionAdapter {
    public function fromStringToInstructions($string);
    public function fromDataToInstructions(array $data);
}
