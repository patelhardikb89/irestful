<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Adapters\Adapters\InstructionAdapterAdapter;
use iRESTful\Instructions\Domain\Assignments\Adapters\Adapters\AssignmentAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionAdapter;
use iRESTful\Instructions\Domain\Databases\Actions\Adapters\Adapters\ActionAdapterAdapter;

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

    public function fromAnnotatedEntitiesToInstructionAdapter(array $annotatedEntities) {
        return new ConcreteInstructionAdapter(
            $this->actionAdapterAdapter,
            $this->assignmentAdapterAdapter,
            $annotatedEntities
        );
    }

}
