<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Combos\Adapters\ComboAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Combos\Exceptions\ComboException;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Combos\Properties\Adapters\PropertyAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteObjectCombo;

final class ConcreteObjectComboAdapter implements ComboAdapter {
    private $propertyAdapter;
    public function __construct(PropertyAdapter $propertyAdapter) {
        $this->propertyAdapter = $propertyAdapter;
    }

    public function fromDataToCombos(array $data) {

        if (!isset($data['object_properties'])) {
            throw new ComboException('The object_properties keyname is mandatory in order to convert data to Combo objects.');
        }

        if (!isset($data['combos'])) {
            throw new ComboException('The combos keyname is mandatory in order to convert data to Combo objects.');
        }

        $output = [];
        foreach($data['combos'] as $oneElement) {
            $output[] = $this->fromStringToCombo($oneElement, $data['object_properties']);
        }

        return $output;
    }

    private function fromStringToCombo(string $line, array $objectProperties) {

        $exploded = explode('|', $line);
        if (count($exploded) != 2) {
            throw new ComboException('The given combo ('.$line.') is ivalid.  There must be only 1 pipe (|) in a combo.');
        }

        $from = $this->propertyAdapter->fromDataToProperty([
            'command' => $exploded[0],
            'object_properties' => $objectProperties
        ]);

        $to = $this->propertyAdapter->fromDataToProperty([
            'command' => $exploded[1],
            'object_properties' => $objectProperties
        ]);

        return new ConcreteObjectCombo($from, $to);

    }

}
