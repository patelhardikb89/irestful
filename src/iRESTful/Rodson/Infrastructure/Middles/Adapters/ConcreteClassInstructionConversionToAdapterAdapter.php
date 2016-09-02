<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\To\Adapters\Adapters\ToAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionConversionToAdapter;

final class ConcreteClassInstructionConversionToAdapterAdapter implements ToAdapterAdapter {

    public function __construct() {

    }

    public function fromDataToToAdapter(array $data) {

        $annotatedClasses = [];
        if (isset($data['annotated_classes'])) {
            $annotatedClasses = $data['annotated_classes'];
        }

        return new ConcreteClassInstructionConversionToAdapter($annotatedClasses);
    }

}
