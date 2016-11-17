<?php
namespace iRESTful\Rodson\TestInstructions\Domain\Comparisons\Adapters;

interface TestInstructionComparisonAdapter {
    public function fromDataToComparison(array $data);
}
