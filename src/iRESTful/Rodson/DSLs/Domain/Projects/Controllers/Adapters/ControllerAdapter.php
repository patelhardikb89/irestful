<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Adapters;

interface ControllerAdapter {
    public function fromDataToControllers(array $data);
    public function fromDataToController(array $data);
}
