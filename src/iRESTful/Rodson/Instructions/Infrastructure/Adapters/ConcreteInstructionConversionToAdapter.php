<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Conversions\To\Adapters\ToAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Objects\ConcreteInstructionConversionTo;
use iRESTful\Rodson\Instructions\Domain\Conversions\From\From;
use iRESTful\Rodson\Instructions\Domain\Conversions\To\Exceptions\ToException;
use iRESTful\Rodson\Instructions\Domain\Containers\Adapters\ContainerAdapter;

final class ConcreteInstructionConversionToAdapter implements ToAdapter {
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
        if (!$isData && ($string != 'entity')) {
            $container = $this->containerAdapter->fromStringToContainer($string);
        }

        return new ConcreteInstructionConversionTo($isData, $isMultiple, $isPartialSet, $container);
    }

}
