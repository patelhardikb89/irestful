<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Assignments\Adapters;

interface AssignmentAdapter {
    public function fromStringToAssignment($string);
}
