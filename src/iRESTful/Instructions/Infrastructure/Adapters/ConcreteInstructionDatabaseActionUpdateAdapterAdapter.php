<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Databases\Actions\Updates\Adapters\Adapters\UpdateAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseActionUpdateAdapter;

final class ConcreteInstructionDatabaseActionUpdateAdapterAdapter implements UpdateAdapterAdapter {

    public function __construct() {

    }

    public function fromDataToUpdateAdapter(array $data) {
        $previousAssignments = null;
        if (isset($data['previous_assignments'])) {
            $previousAssignments = $data['previous_assignments'];
        }

        return new ConcreteInstructionDatabaseActionUpdateAdapter($previousAssignments);
    }

}
