<?php
namespace iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Actions\Adapters;

interface ActionAdapter {
    public function fromStringToAction($string);
}
