<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Controllers\Adapters\Adapters;

interface ControllerAdapterAdapter {
    public function fromAnnotatedClassesToControllerAdapter(array $annotatedClasses);
}
