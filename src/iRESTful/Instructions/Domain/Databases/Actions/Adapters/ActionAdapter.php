<?php
namespace iRESTful\Instructions\Domain\Databases\Actions\Adapters;

interface ActionAdapter {
    public function fromStringToAction($string);
}
