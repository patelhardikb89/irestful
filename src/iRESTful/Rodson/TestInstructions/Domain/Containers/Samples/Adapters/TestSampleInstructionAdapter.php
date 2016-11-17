<?php
namespace iRESTful\Rodson\TestInstructions\Domain\Containers\Samples\Adapters;

interface TestSampleInstructionAdapter {
    public function fromDataToTestSampleInstructions(array $data);
}
