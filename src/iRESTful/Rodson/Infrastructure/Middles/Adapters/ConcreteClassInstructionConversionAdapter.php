<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Adapters\ConversionAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Elements\Adapters\Adapters\ElementAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionConversion;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Exceptions\ConversionException;

final class ConcreteClassInstructionConversionAdapter implements ConversionAdapter {
    private $elementAdapterAdapter;
    private $classes;
    private $previousAssignments;
    private $inputName;
    public function __construct(ElementAdapterAdapter $elementAdapterAdapter, array $classes, array $previousAssignments, $inputName) {
        $this->elementAdapterAdapter = $elementAdapterAdapter;
        $this->classes = $classes;
        $this->previousAssignments = $previousAssignments;
        $this->inputName = $inputName;
    }
    
    public function fromStringToConversion($string) {

        $matches = [];
        preg_match_all('/from ([^ ]+) to (.+)/s', $string, $matches);
        if (($matches[0][0] == $string) && isset($matches[1][0]) && isset($matches[2][0]) && !empty($matches[1][0]) && !empty($matches[2][0])) {
            $elementAdapterAdapter = $this->elementAdapterAdapter->fromDataToElementAdapter([
                'classes' => $this->classes,
                'assignments' => $this->previousAssignments,
                'input' => $this->inputName
            ]);

            $from = $elementAdapterAdapter->fromStringToElement($matches[1][0]);
            $to = $elementAdapterAdapter->fromStringToElement($matches[2][0]);

            return new ConcreteClassInstructionConversion($from, $to);
        }

        throw new ConversionException('THe given command ('.$string.') does not reference a valid Conversion object.');
    }

}
