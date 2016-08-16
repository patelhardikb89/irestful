<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Deletes\Adapters\Adapters\DeleteAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseActionDeleteAdapter;

final class ConcreteClassInstructionDatabaseActionDeleteAdapterAdapter implements DeleteAdapterAdapter {

    public function __construct() {

    }

    public function fromDataToDeleteAdapter(array $data) {
        $previousAssignments = null;
        if (isset($data['previous_assignments'])) {
            $previousAssignments = $data['previous_assignments'];
        }

        return new ConcreteClassInstructionDatabaseActionDeleteAdapter($previousAssignments);
    }

}
