<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Adapters\ConversionAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\From\Adapters\FromAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\To\Adapters\ToAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionConversion;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Exceptions\ConversionException;

final class ConcreteClassInstructionConversionAdapter implements ConversionAdapter {
    private $fromAdapter;
    private $toAdapter;
    public function __construct(FromAdapter $fromAdapter, ToAdapter $toAdapter) {
        $this->fromAdapter = $fromAdapter;
        $this->toAdapter = $toAdapter;
    }

    public function fromStringToConversion($string) {

        $matches = [];
        preg_match_all('/from ([^ ]+) to (.+)/s', $string, $matches);
        if (($matches[0][0] == $string) && isset($matches[1][0]) && isset($matches[2][0]) && !empty($matches[1][0]) && !empty($matches[2][0])) {
            $from = $this->fromAdapter->fromStringToFrom($matches[1][0]);
            $to = $this->toAdapter->fromStringToTo($matches[2][0]);

            if (!$from->isMultiple() && $to->isMultiple()) {
                if (!$from->isInput()) {
                    throw new ConversionException("The use of the 'multiple' keyword when the from is not the input is illegal.  The conversion string was: ".$string);
                }

                $from->isNowMultiple();
            }

            return new ConcreteClassInstructionConversion($from, $to);
        }

        throw new ConversionException('The given command ('.$string.') does not reference a valid Conversion object.');
    }

}
