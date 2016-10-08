<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Adapters\Adapters;

interface TestInstructionAdapterAdapter {
    public function fromAnnotatedEntitiesToTestInstructionAdapter(array $annotatedEntities);
}
