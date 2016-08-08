<?php
namespace iRESTful\Rodson\Domain\Outputs\Codes\Adapters;
use iRESTful\Rodson\Domain\Middles\Annotations\Classes\AnnotatedClass;
use iRESTful\Rodson\Domain\Middles\Configurations\Configuration;
use iRESTful\Rodson\Domain\Middles\Tests\Functionals\Transforms\TransformTest;

interface CodeAdapter {
    public function fromConfigurationToCode(Configuration $configuration);
    public function fromAnnotatedClassToCodes(AnnotatedClass $annotatedClass);
    public function fromAnotatedClassesToCodes(array $annotatedClasses);
    public function fromFunctionalTransformTestsToCodes(array $functionalTransformTests);
    public function fromFunctionalTransformTestToCode(TransformTest $functionalTransformTest);
}
