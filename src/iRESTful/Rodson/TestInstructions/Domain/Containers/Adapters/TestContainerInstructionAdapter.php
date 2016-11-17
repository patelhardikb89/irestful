<?php
namespace iRESTful\Rodson\TestInstructions\Domain\Containers\Adapters;

interface TestContainerInstructionAdapter {
    public function fromDataToTestContainerInstructions(array $data);
}
