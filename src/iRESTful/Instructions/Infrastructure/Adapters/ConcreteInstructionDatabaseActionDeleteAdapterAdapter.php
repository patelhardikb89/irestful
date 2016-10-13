<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Databases\Actions\Deletes\Adapters\Adapters\DeleteAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseActionDeleteAdapter;

final class ConcreteInstructionDatabaseActionDeleteAdapterAdapter implements DeleteAdapterAdapter {

    public function __construct() {

    }

    public function fromDataToDeleteAdapter(array $data) {
        $previousAssignments = null;
        if (isset($data['previous_assignments'])) {
            $previousAssignments = $data['previous_assignments'];
        }

        return new ConcreteInstructionDatabaseActionDeleteAdapter($previousAssignments);
    }

}
