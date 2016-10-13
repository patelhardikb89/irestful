<?php
namespace iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands;

interface Command {
    public function getAction();
    public function getUrl();
}
