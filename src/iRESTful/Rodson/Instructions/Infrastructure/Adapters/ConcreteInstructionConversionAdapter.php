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
            return new ConcreteInstructionConversion($from, $to);
        }

        throw new ConversionException('The given command ('.$string.') does not reference a valid Conversion object.');
    }

}
