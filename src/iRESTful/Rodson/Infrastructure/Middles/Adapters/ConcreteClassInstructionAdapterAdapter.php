<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Adapters\Adapters\InstructionAdapterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Assignments\Adapters\Adapters\AssignmentAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Adapters\Adapters\ActionAdapterAdapter;

final class ConcreteClassInstructionAdapterAdapter implements InstructionAdapterAdapter {
    private $actionAdapterAdapter;
    private $assignmentAdapterAdapter;
    public function __construct(ActionAdapterAdapter $actionAdapterAdapter, AssignmentAdapterAdapter $assignmentAdapterAdapter) {
        $this->actionAdapterAdapter = $actionAdapterAdapter;
        $this->assignmentAdapterAdapter = $assignmentAdapterAdapter;
    }

    public function fromClassesToInstructionAdapter(array $classes) {
        return new ConcreteClassInstructionAdapter($this->actionAdapterAdapter, $this->assignmentAdapterAdapter, $classes);
    }

}
