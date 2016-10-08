<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Values\Loops\Adapters\LoopAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionValue;

final class ConcreteClassInstructionValueAdapter implements ValueAdapter {
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

        return new ConcreteClassInstructionValue($loop, $value);

    }

}
