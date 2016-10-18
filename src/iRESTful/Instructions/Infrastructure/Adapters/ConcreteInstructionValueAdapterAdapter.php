<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Values\Adapters\Adapters\ValueAdapterAdapter as InstructionValueAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionValueAdapter;
use iRESTful\DSLs\Domain\Projects\Values\Adapters\Adapters\ValueAdapterAdapter;
use iRESTful\Instructions\Domain\Values\Loops\Adapters\LoopAdapter;

final class ConcreteInstructionValueAdapterAdapter implements InstructionValueAdapterAdapter {
    private $loopAdapter;
    private $valueAdapterAdapter;
    public function __construct(LoopAdapter $loopAdapter, ValueAdapterAdapter $valueAdapterAdapter) {
        $this->loopAdapter = $loopAdapter;
        $this->valueAdapterAdapter = $valueAdapterAdapter;
    }

    public function fromDataToValueAdapter(array $data) {
        $valueAdapter = $this->valueAdapterAdapter->fromDataToValueAdapter($data);
        return new ConcreteInstructionValueAdapter($this->loopAdapter, $valueAdapter);
    }

}
