<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases;

interface Database {
    public function hasRetrieval();
    public function getRetrieval();
    public function hasAction();
    public function getAction();
    public function hasActions();
    public function getActions();
}
