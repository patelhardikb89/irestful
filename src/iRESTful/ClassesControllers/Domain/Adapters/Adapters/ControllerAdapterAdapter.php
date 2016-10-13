<?php
namespace iRESTful\ClassesControllers\Domain\Adapters\Adapters;

interface ControllerAdapterAdapter {
    public function fromAnnotatedEntitiesToControllerAdapter(array $annotatedEntities);
}
