<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Objects;
use iRESTful\Rodson\Instructions\Domain\Conversions\Conversion;
use iRESTful\Rodson\Instructions\Domain\Conversions\From\From;
use iRESTful\Rodson\Instructions\Domain\Conversions\To\To;
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Converter;
use iRESTful\Rodson\Instructions\Domain\Conversions\Exceptions\ConversionException;

final class ConcreteInstructionConversion implements Conversion {
    private $from;
    private $to;
    private $converter;
    public function __construct(From $from = null, To $to = null, Converter $converter = null) {

        $amount = ((!empty($from) && !empty($to)) ? 1 : 0) + (!empty($converter) ? 1 : 0);
        if ($amount != 1) {
            throw new ConversionException('The conversion must either have a From and To or a Converter object.  '.$amount.' given.');
        }

        $this->from = $from;
        $this->to = $to;
        $this->converter = $converter;
    }

    public function hasFrom() {
        return !empty($this->from);
    }

    public function getFrom() {
        return $this->from;
    }

    public function hasTo() {
        return !empty($this->to);
    }

    public function getTo() {
        return $this->to;
    }

    public function hasConverter() {
        return !empty($this->converter);
    }

    public function getConverter() {
        return $this->converter;
    }

}
