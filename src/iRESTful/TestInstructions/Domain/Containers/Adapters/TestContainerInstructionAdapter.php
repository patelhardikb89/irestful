<?php
namespace iRESTful\TestInstructions\Domain\Containers\Adapters;

interface TestContainerInstructionAdapter {
    public function fromDataToTestContainerInstructions(array $data);
}
