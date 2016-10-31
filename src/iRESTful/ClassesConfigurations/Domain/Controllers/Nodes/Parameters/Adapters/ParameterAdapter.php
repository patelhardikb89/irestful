<?php
namespace iRESTful\ClassesConfigurations\Domain\Controllers\Nodes\Parameters\Adapters;

interface ParameterAdapter {
    public function fromControllersToParameters(array $controllers);
}
