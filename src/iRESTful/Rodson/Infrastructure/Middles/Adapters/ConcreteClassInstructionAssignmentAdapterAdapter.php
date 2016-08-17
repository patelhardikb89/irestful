<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Assignments\Adapters\Adapters\AssignmentAdapterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Adapters\Adapters\DatabaseAdapterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Adapters\Adapters\ConversionAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionAssignmentAdapter;

final class ConcreteClassInstructionAssignmentAdapterAdapter implements AssignmentAdapterAdapter {
    private $databaseAdapterAdapter;
    private $conversionAdapterAdapter;
    public function __construct(DatabaseAdapterAdapter $databaseAdapterAdapter, ConversionAdapterAdapter $conversionAdapterAdapter) {
        $this->databaseAdapterAdapter = $databaseAdapterAdapter;
        $this->conversionAdapterAdapter = $conversionAdapterAdapter;
    }

    public function fromDataToAssignmentAdapter(array $data) {

        if (!isset($data['classes'])) {
            //throws
        }

        if (!isset($data['controller'])) {
            //throws
        }

        if (!isset($data['input'])) {
            //throws
        }

        $previousAssignments = null;
        if (isset($data['previous_assignments'])) {
            $previousAssignments = $data['previous_assignments'];
        }

        $databaseAdapter = $this->databaseAdapterAdapter->fromDataToDatabaseAdapter([
            'controller' => $data['controller'],
            'classes' => $data['classes'],
            'previous_assignments' => $previousAssignments
        ]);

        return new ConcreteClassInstructionAssignmentAdapter(
            $databaseAdapter,
            $this->conversionAdapterAdapter,
            $data['input'],
            $data['classes'],
            $previousAssignments
        );
    }

}