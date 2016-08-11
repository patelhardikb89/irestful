<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Instructions\Databases;

interface Database {
    public function hasRetrieval();
    public function getRetrieval();
    public function hasAction();
    public function getAction();
}
