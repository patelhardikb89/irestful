<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Commands\Actions\Adapters;

interface ActionAdapter {
    public function fromStringToAction($string);
}
