<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Inserts\Adapters\Adapters\InsertAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseActionInsertAdapter;

final class ConcreteClassInstructionDatabaseActionInsertAdapterAdapter implements InsertAdapterAdapter {

    public function __construct() {

    }

    public function fromDataToInsertAdapter(array $data) {
        $previousAssignments = null;
        if (isset($data['previous_assignments'])) {
            $previousAssignments = $data['previous_assignments'];
        }

        return new ConcreteClassInstructionDatabaseActionInsertAdapter($previousAssignments);
    }

}
