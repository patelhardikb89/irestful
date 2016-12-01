<?php
namespace iRESTful\Rodson\ClassesControllers\Domain\Adapters\Adapters;

interface ControllerAdapterAdapter {
    public function fromDataToControllerAdapter(array $data);
}
