<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Updates\Adapters\Adapters\UpdateAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseActionUpdateAdapter;

final class ConcreteClassInstructionDatabaseActionUpdateAdapterAdapter implements UpdateAdapterAdapter {

    public function __construct() {

    }

    public function fromDataToUpdateAdapter(array $data) {
        $previousAssignments = null;
        if (isset($data['previous_assignments'])) {
            $previousAssignments = $data['previous_assignments'];
        }

        return new ConcreteClassInstructionDatabaseActionUpdateAdapter($previousAssignments);
    }

}
