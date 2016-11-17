<?php
namespace iRESTful\Rodson\ClassesControllers\Domain\Adapters\Adapters;

interface ControllerAdapterAdapter {
    public function fromAnnotatedEntitiesToControllerAdapter(array $annotatedEntities);
}
