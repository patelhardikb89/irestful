<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Databases\Actions\Inserts\Adapters\Adapters\InsertAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseActionInsertAdapter;

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
