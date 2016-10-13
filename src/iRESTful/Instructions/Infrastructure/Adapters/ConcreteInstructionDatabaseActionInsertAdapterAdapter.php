<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Databases\Actions\Inserts\Adapters\Adapters\InsertAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseActionInsertAdapter;

final class ConcreteInstructionDatabaseActionInsertAdapterAdapter implements InsertAdapterAdapter {

    public function __construct() {

    }

    public function fromDataToInsertAdapter(array $data) {
        $previousAssignments = null;
        if (isset($data['previous_assignments'])) {
            $previousAssignments = $data['previous_assignments'];
        }

        return new ConcreteInstructionDatabaseActionInsertAdapter($previousAssignments);
    }

}
