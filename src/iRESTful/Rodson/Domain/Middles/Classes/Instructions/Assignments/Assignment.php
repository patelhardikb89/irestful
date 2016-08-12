<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Assignments;

interface Assignment {
    public function isReturned();
    public function hasVariableName();
    public function getVariableName();
    public function hasDatabase();
    public function getDatabase();
    public function hasConversion();
    public function getConversion();
}
