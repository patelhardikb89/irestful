<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Values\Adapters\Adapters\ValueAdapterAdapter as InstructionValueAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionValueAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Values\Adapters\Adapters\ValueAdapterAdapter;
use iRESTful\Rodson\Instructions\Domain\Values\Loops\Adapters\LoopAdapter;

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
