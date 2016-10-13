<?php
namespace iRESTful\DSLs\Domain\Projects\Controllers\Adapters;

interface ControllerAdapter {
    public function fromDataToControllers(array $data);
    public function fromDataToController(array $data);
}
