<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Commands;

interface Command {
    public function getAction();
    public function getUrl();
    public function getData();
}
