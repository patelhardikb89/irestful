<?php
namespace iRESTful\Rodson\ClassesConfigurations\Domain\Controllers\Nodes\Parameters\Adapters;

interface ParameterAdapter {
    public function fromControllersToParameters(array $controllers);
}
