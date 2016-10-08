<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Containers\Adapters;

interface TestContainerInstructionAdapter {
    public function fromDataToTestContainerInstructions(array $data);
}
