<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Adapters\Adapters\InstructionAdapterAdapter;
use iRESTful\Rodson\Instructions\Domain\Assignments\Adapters\Adapters\AssignmentAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionAdapter;
use iRESTful\Rodson\Instructions\Domain\Databases\Actions\Adapters\Adapters\ActionAdapterAdapter;
use iRESTful\Rodson\Instructions\Domain\Exceptions\InstructionException;

final class ConcreteInstructionAdapterAdapter implements InstructionAdapterAdapter {
    private $actionAdapterAdapter;
    private $assignmentAdapterAdapter;
    public function __construct(
        ActionAdapterAdapter $actionAdapterAdapter,
        AssignmentAdapterAdapter $assignmentAdapterAdapter
    ) {
        $this->actionAdapterAdapter = $actionAdapterAdapter;
        $this->assignmentAdapterAdapter = $assignmentAdapterAdapter;
    }

    public function fromDataToInstructionAdapter(array $data) {

        if (!isset($data['annotated_entities'])) {
            throw new InstructionException('The annotated_entities keyname is mandatory in order to convert data to an InstructionAdapter object.');
        }

        $converters = [];
        if (isset($data['converters'])) {
            $converters = $data['converters'];
        }

        return new ConcreteInstructionAdapter(
            $this->actionAdapterAdapter,
            $this->assignmentAdapterAdapter,
            $data['annotated_entities'],
            $converters
        );
    }

}
