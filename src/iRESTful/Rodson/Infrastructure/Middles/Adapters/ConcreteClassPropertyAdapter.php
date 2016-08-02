<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Properties\Adapters\PropertyAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassProperty;

final class ConcreteClassPropertyAdapter implements PropertyAdapter {

    public function __construct() {

    }

    public function fromNameToProperty($name) {

        $convert = function($name) {

            $matches = [];
            preg_match_all('/\_[\s\S]{1}/s', $name, $matches);

            foreach($matches[0] as $oneElement) {
                $replacement = strtoupper(str_replace('_', '', $oneElement));
                $name = str_replace($oneElement, $replacement, $name);
            }

            return lcfirst($name);

        };
        
        $name = $convert($name);
        return new ConcreteClassProperty($name);
    }

}
