<?php
namespace iRESTful\TestInstructions\Domain\Comparisons\Adapters;

interface TestInstructionComparisonAdapter {
    public function fromDataToComparison(array $data);
}
