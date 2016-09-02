<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Controllers\Adapters;
use iRESTful\Rodson\Domain\Inputs\Controllers\Controller;
use iRESTful\Rodson\Domain\Inputs\Rodson;

interface ControllerAdapter {
    public function fromRodsonToClassControllers(Rodson $rodson);
}
