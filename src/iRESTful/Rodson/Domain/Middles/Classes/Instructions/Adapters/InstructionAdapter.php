<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Adapters;

interface InstructionAdapter {
    public function fromStringToInstructions($string);
    public function fromDataToInstructions(array $data);
}
