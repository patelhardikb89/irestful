<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Databases\Actions\Deletes\Adapters\Adapters\DeleteAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseActionDeleteAdapter;

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
