<?php
namespace iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Adapters;

interface CommandAdapter {
    public function fromStringToCommand($string);
}
