<?php
namespace iRESTful\Rodson\Domain\Middles\Configurations\Controllers\Adapters;

interface ControllerAdapter {
    public function fromDataToControllers(array $data);
}
