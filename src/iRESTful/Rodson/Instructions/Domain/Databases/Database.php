<?php
namespace iRESTful\Rodson\Instructions\Domain\Databases;

interface Database {
    public function hasRetrieval();
    public function getRetrieval();
    public function hasAction();
    public function getAction();
}
