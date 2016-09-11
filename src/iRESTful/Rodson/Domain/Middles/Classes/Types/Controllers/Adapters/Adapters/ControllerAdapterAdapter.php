<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Controllers\Adapters\Adapters;

interface ControllerAdapterAdapter {
    public function fromAnnotatedEntitiesToControllerAdapter(array $annotatedEntities);
}
