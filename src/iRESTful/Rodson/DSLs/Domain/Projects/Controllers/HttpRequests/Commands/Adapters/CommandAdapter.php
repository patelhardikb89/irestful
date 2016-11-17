<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Adapters;

interface CommandAdapter {
    public function fromStringToCommand($string);
}
