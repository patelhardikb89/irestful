<?php
namespace iRESTful\Instructions\Domain\Assignments\Adapters\Adapters;

interface AssignmentAdapterAdapter {
    public function fromDataToAssignmentAdapter(array $data);
}
