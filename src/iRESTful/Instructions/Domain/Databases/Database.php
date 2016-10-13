<?php
namespace iRESTful\Instructions\Domain\Databases;

interface Database {
    public function hasRetrieval();
    public function getRetrieval();
    public function hasAction();
    public function getAction();
}
