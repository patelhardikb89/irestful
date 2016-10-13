<?php
namespace iRESTful\ClassesConfigurations\Domain\Controllers\Nodes\Adapters;

interface ControllerNodeAdapter {
    public function fromDataToControllerNode(array $data);
}
