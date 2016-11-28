<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Combos\Properties\Property;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Properties\Property as ObjectProperty;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Combos\Properties\Exceptions\PropertyException;

final class ConcreteObjectComboProperty implements Property {
    private $objectProperties;
    private $isDefault;
    public function __construct(array $objectProperties, bool $isDefault) {

        if (empty($objectProperties)) {
            throw new PropertyException('The objectProperties array cannot be empty.');
        }

        foreach($objectProperties as $oneObjectProperty) {
            if (!($oneObjectProperty instanceof ObjectProperty)) {
                throw new PropertyException('The objectProperties array must only contain Property objects.');
            }

            $name = $oneObjectProperty->getName();
            if (!$oneObjectProperty->isOptional()) {
                throw new PropertyException('The object property ('.$name.') cannot be in a combo because it is not optional.');
            }

            $type = $oneObjectProperty->getType();
            if ($type->isArray()) {
                throw new PropertyException('The object property ('.$name.') cannot be in a combo because its type is an array.');
            }

            if ($isDefault && !$type->hasPrimitive()) {
                throw new PropertyException('The object property ('.$name.') cannot be in a default combo because its type is not primitive.');
            }
        }

        $this->objectProperties = $objectProperties;
        $this->isDefault = $isDefault;

    }

    public function getObjectProperties() {
        return $this->objectProperties;
    }

    public function isDefault() {
        return $this->isDefault;
    }

}
