<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\To\Adapters\ToAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionConversionTo;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\From\From;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\To\Exceptions\ToException;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Adapters\ContainerAdapter;

final class ConcreteClassInstructionConversionToAdapter implements ToAdapter {
    private $containerAdapter;
    public function __construct(ContainerAdapter $containerAdapter) {
        $this->containerAdapter = $containerAdapter;
    }

    public function fromStringToTo($string) {

        $isMultiple = false;
        if (strpos($string, 'multiple ') === 0) {
            $string = substr($string, strlen('multiple '));
            $isMultiple = true;
        }

        $isPartialSet = false;
        $matches = [];
        preg_match_all('/partial ([^ ]+) list/s', $string, $matches);
        if (isset($matches[0][0]) && ($matches[0][0] == $string)) {
            $string = $matches[1][0];
            $isPartialSet = true;
        }

        $isData = false;
        if ($string == 'data') {
            $isData = true;
        }

        $container = null;
        if (!$isData) {
            $container = $this->containerAdapter->fromStringToContainer($string);
        }
        
        return new ConcreteClassInstructionConversionTo($isData, $isMultiple, $isPartialSet, $container);
    }

}
