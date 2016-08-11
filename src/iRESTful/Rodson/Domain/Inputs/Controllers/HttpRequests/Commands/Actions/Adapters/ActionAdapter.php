<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\Commands\Actions\Adapters;

interface ActionAdapter {
    public function fromStringToAction($string);
}
