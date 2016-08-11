<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\Commands\Adapters;

interface CommandAdapter {
    public function fromStringToCommand($string);
}
