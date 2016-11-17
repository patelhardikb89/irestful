<?php
namespace iRESTful\Rodson\ClassesConfigurations\Domain\Controllers\Adapters;

interface ControllerAdapter {
    public function fromDataToControllers(array $data);
}
