<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Conversions\Adapters\ConversionAdapter;
use iRESTful\Rodson\Instructions\Domain\Conversions\From\Adapters\FromAdapter;
use iRESTful\Rodson\Instructions\Domain\Conversions\To\Adapters\ToAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Objects\ConcreteInstructionConversion;
use iRESTful\Rodson\Instructions\Domain\Conversions\Exceptions\ConversionException;

final class ConcreteInstructionConversionAdapter implements ConversionAdapter {
    private $fromAdapter;
    private $toAdapter;
    private $converters;
    public function __construct(FromAdapter $fromAdapter, ToAdapter $toAdapter, array $converters) {
        $this->fromAdapter = $fromAdapter;
        $this->toAdapter = $toAdapter;
        $this->converters = $converters;
    }

    public function fromStringToConversion($string) {

        $matches = [];
        preg_match_all('/from ([^ ]+) to (.+)/s', $string, $matches);

        if (($matches[0][0] == $string) && isset($matches[1][0]) && isset($matches[2][0]) && !empty($matches[1][0]) && !empty($matches[2][0])) {

            $keyname = 'from_'.$matches[1][0].'_to_'.$matches[2][0];
            if (isset($this->converters[$keyname])) {
                return new ConcreteInstructionConversion(null, null, $this->converters[$keyname]);
            }

            $from = $this->fromAdapter->fromStringToFrom($matches[1][0]);
            $to = $this->toAdapter->fromStringToTo($matches[2][0]);
            return new ConcreteInstructionConversion($from, $to);
        }

        throw new ConversionException('The given command ('.$string.') does not reference a valid Conversion object.');
    }

}
