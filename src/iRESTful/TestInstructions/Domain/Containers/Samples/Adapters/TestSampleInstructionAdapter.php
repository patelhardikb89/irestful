<?php
namespace iRESTful\TestInstructions\Domain\Containers\Samples\Adapters;

interface TestSampleInstructionAdapter {
    public function fromDataToTestSampleInstructions(array $data);
}
