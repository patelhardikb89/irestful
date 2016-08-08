<?php
namespace iRESTful\Rodson\Domain\Middles\Tests\Functionals\Transforms\Adapters;

interface TransformTestAdapter {
    public function fromAnnotatedClassesToTransformTests(array $annotatedClasses);
}
