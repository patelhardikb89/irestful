<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Containers\Samples\Adapters;

interface TestSampleInstructionAdapter {
    public function fromDataToTestSampleInstructions(array $data);
}
