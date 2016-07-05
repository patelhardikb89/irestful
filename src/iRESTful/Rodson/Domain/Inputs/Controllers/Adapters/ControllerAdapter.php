<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Adapters;

interface ControllerAdapter {
    public function fromDataToControllers(array $data);
    public function fromDataToController(array $data);
}
