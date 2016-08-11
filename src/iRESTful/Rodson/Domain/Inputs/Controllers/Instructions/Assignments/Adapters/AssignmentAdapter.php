<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Instructions\Assignments\Adapters;

interface AssignmentAdapter {
    public function fromStringToAssignment($string);
}
