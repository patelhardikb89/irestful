<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Commands\Adapters;

interface CommandAdapter {
    public function fromStringToCommand($string);
}
