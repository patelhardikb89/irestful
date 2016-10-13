<?php
namespace iRESTful\Classes\Infrastructure\Adapters;
use iRESTful\Classes\Domain\Properties\Adapters\PropertyAdapter;
use iRESTful\Classes\Infrastructure\Objects\ConcreteClassProperty;

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
