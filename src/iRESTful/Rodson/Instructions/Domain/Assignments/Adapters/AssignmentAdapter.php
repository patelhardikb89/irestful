<?php
namespace iRESTful\Rodson\Instructions\Domain\Assignments\Adapters;

interface AssignmentAdapter {
    public function fromStringToAssignment($string);
}
