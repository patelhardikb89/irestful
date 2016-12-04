<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Properties\Adapters\PropertyAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteObject;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Exceptions\ObjectException;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Properties\Exceptions\PropertyException;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Adapters\ObjectAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Combos\Adapters\ComboAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Converter;

final class ConcreteObjectAdapter implements ObjectAdapter {
    private $propertyAdapter;
    private $comboAdapter;
    private $databases;
    private $parents;
    private $converters;
    public function __construct(
        PropertyAdapter $propertyAdapter,
        ComboAdapter $comboAdapter,
        array $databases,
        array $parents,
        array $converters
    ) {
        $this->propertyAdapter = $propertyAdapter;
        $this->comboAdapter = $comboAdapter;
        $this->databases = $databases;
        $this->parents = $parents;
        $this->converters = $converters;
    }

    public function fromDataToValidObjects(array $data) {
        return $this->convertMultipleDataToObjects($data, false);
    }

    public function fromDataToObjects(array $data) {
        return $this->convertMultipleDataToObjects($data, true);
    }

    public function fromDataToObject(array $data) {

        if (!isset($data['name'])) {
            throw new ObjectException('The name keyname is mandatory in order to convert data to an Object object.');
        }

        if (!isset($data['properties'])) {
            throw new ObjectException('The properties keyname is mandatory in order to convert data to Property objects.');
        }

        $getConverters = function($name) {

            $get = function(Converter $converter) use(&$name) {
                if ($converter->hasFromType()) {
                    $fromType = $converter->fromType();
                    if ($fromType->hasObjectReferenceName()) {
                        $referenceName = $fromType->getObjectReferenceName();
                        if ($referenceName == $name) {
                            return $converter;
                        }

                        return null;
                    }

                    if ($fromType->hasType()) {
                        return null;
                    }
                }

                if (!$converter->hasToType()) {
                    return null;
                }

                $toType = $converter->toType();
                if ($toType->hasObjectReferenceName()) {
                    $referenceName = $toType->getObjectReferenceName();
                    if ($referenceName == $name) {
                        return $converter;
                    }
                }

                return null;
            };

            $output = [];
            foreach($this->converters as $oneConverter) {
                $referencedConverter = $get($oneConverter);
                if (!empty($referencedConverter)) {
                    $output[] = $referencedConverter;
                }

            }

            return $output;

        };

        try {

            $database = null;
            if (isset($data['database'])) {

                if (!isset($this->databases[$data['database']])) {
                    throw new ObjectException('The referenced database ('.$data['database'].') does not exists.');
                }

                $database = $this->databases[$data['database']];
            }

            $properties = $this->propertyAdapter->fromDataToProperties([
                'properties' => $data['properties'],
                'parents' => $this->parents
            ]);

            $combos = null;
            if (isset($data['combos'])) {
                $combos = $this->comboAdapter->fromDataToCombos([
                    'object_properties' => $properties,
                    'combos' => $data['combos']
                ]);
            }

            $converters = $getConverters($data['name']);
            return new ConcreteObject($data['name'], $properties, $database, $combos, $converters);

        } catch (PropertyException $exception) {
            throw new ObjectException('There was an exception while converting data to Property objects.', $exception);
        }
    }

    private function convertMultipleDataToObjects(array $data, $throwException) {
        $output = [];
        foreach($data as $name => $oneData) {

            try {

                $oneData['name'] = $name;
                $output[$name] = $this->fromDataToObject($oneData);

            } catch (ObjectException $exception) {

                if ($throwException) {
                    throw $exception;
                }

                continue;

            }
        }

        return $output;
    }

}
