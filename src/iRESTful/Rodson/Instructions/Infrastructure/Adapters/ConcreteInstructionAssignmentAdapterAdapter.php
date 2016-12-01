<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Assignments\Adapters\Adapters\AssignmentAdapterAdapter;
use iRESTful\Rodson\Instructions\Domain\Databases\Adapters\Adapters\DatabaseAdapterAdapter;
use iRESTful\Rodson\Instructions\Domain\Conversions\Adapters\Adapters\ConversionAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionAssignmentAdapter;
use iRESTful\Rodson\Instructions\Domain\Assignments\Exceptions\AssignmentException;

final class ConcreteInstructionAssignmentAdapterAdapter implements AssignmentAdapterAdapter {
    private $databaseAdapterAdapter;
    private $conversionAdapterAdapter;
    public function __construct(DatabaseAdapterAdapter $databaseAdapterAdapter, ConversionAdapterAdapter $conversionAdapterAdapter) {
        $this->databaseAdapterAdapter = $databaseAdapterAdapter;
        $this->conversionAdapterAdapter = $conversionAdapterAdapter;
    }

    public function fromDataToAssignmentAdapter(array $data) {

        if (!isset($data['annotated_entities'])) {
            throw new AssignmentException('The annotated_entities keyname is mandatory in order to convert data to an AssignmentAdapter.');
        }

        if (!isset($data['controller'])) {
            throw new AssignmentException('The controller keyname is mandatory in order to convert data to an AssignmentAdapter.');
        }

        if (!isset($data['input'])) {
            throw new AssignmentException('The input keyname is mandatory in order to convert data to an AssignmentAdapter.');
        }

        $converters = null;
        if (isset($data['converters'])) {
            $converters = $data['converters'];
        }

        $previousAssignments = null;
        if (isset($data['previous_assignments'])) {
            $previousAssignments = $data['previous_assignments'];
        }

        $databaseAdapter = $this->databaseAdapterAdapter->fromDataToDatabaseAdapter([
            'controller' => $data['controller'],
            'annotated_entities' => $data['annotated_entities'],
            'previous_assignments' => $previousAssignments
        ]);

        return new ConcreteInstructionAssignmentAdapter(
            $databaseAdapter,
            $this->conversionAdapterAdapter,
            $data['input'],
            $data['annotated_entities'],
            $converters,
            $previousAssignments
        );
    }

}
