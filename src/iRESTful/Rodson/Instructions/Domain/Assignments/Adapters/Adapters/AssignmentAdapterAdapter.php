<?php
namespace iRESTful\Rodson\Instructions\Domain\Assignments\Adapters\Adapters;

interface AssignmentAdapterAdapter {
    public function fromDataToAssignmentAdapter(array $data);
}
