<?php
namespace iRESTful\Rodson\Instructions\Domain\Databases\Actions\Adapters;

interface ActionAdapter {
    public function fromStringToAction($string);
}
