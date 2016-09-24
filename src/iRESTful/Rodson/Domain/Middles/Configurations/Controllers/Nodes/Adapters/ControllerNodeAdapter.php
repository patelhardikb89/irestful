<?php
namespace iRESTful\Rodson\Domain\Middles\Configurations\Controllers\Nodes\Adapters;

interface ControllerNodeAdapter {
    public function fromDataToControllerNode(array $data);
}
