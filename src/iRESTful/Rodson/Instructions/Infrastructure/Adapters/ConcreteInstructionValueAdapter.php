<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Values\Adapters\ValueAdapter as InstructionValueAdapter;
use iRESTful\Rodson\Instructions\Domain\Values\Loops\Adapters\LoopAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Objects\ConcreteInstructionValue;

final class ConcreteInstructionValueAdapter implements InstructionValueAdapter {
    private $loopAdapter;
    private $valueAdapter;
    public function __construct(LoopAdapter $loopAdapter, ValueAdapter $valueAdapter) {
        $this->loopAdapter = $loopAdapter;
        $this->valueAdapter = $valueAdapter;
    }

    public function fromDataToValues(array $data) {
        $output = [];
        foreach($data as $oneString) {
            $output[] = $this->fromStringToValue($oneString);
        }

        return $output;
    }

    public function fromStringToValue($string) {

        $loop = null;
        if (strpos($string, '$each') !== false) {
            $loop = $this->loopAdapter->fromStringToLoop($string);
        }

        $value = null;
        if (empty($loop)) {
            $value = $this->valueAdapter->fromStringToValue($string);
        }

        return new ConcreteInstructionValue($loop, $value);

    }

}
