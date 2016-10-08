<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Comparisons\Adapters;

interface TestInstructionComparisonAdapter {
    public function fromDataToComparison(array $data);
}
