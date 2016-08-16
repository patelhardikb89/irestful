<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Assignments\Adapters\Adapters;

interface AssignmentAdapterAdapter {
    public function fromDataToAssignmentAdapter(array $data);
}
