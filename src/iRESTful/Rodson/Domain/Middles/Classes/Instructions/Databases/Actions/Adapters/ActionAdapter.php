<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Adapters;

interface ActionAdapter {
    public function fromStringToAction($string);
}
