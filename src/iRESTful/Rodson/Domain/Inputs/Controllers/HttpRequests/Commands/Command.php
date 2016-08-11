<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\Commands;

interface Command {
    public function getAction();
    public function getUrl();
}
