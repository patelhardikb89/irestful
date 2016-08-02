<?php
namespace iRESTful\Rodson\Domain\Outputs\Codes\Adapters;
use iRESTful\Rodson\Domain\Middles\Annotations\Classes\AnnotatedClass;

interface CodeAdapter {
    public function fromAnnotatedClassToCodes(AnnotatedClass $annotatedClass);
    public function fromAnotatedClassesToCodes(array $annotatedClasses);
}
