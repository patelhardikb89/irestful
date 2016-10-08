<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Controllers\Adapters;

interface ControllerAdapter {
    public function fromDataToControllers(array $data);
    public function fromDataToController(array $data);
}
