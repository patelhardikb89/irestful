<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Values\Adapters\ValueAdapter;
use iRESTful\Instructions\Domain\Values\Loops\Adapters\LoopAdapter;
use iRESTful\Instructions\Domain\Values\Adapters\ValueAdapter;
use iRESTful\Instructions\Infrastructure\Objects\ConcreteInstructionValue;

final class ConcreteInstructionValueAdapter implements ValueAdapter {
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
