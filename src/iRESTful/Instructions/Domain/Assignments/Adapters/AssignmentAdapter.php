<?php
namespace iRESTful\Instructions\Domain\Assignments\Adapters;

interface AssignmentAdapter {
    public function fromStringToAssignment($string);
}
