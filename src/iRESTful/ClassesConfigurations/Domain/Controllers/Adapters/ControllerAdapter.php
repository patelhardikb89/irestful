<?php
namespace iRESTful\ClassesConfigurations\Domain\Controllers\Adapters;

interface ControllerAdapter {
    public function fromDataToControllers(array $data);
}
