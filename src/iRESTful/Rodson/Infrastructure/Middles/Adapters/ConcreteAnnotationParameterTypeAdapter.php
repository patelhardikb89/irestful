<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Types\Adapters\TypeAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Properties\Property;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteAnnotationParameterType;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Adapters\DatabaseTypeAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;

final class ConcreteAnnotationParameterTypeAdapter implements TypeAdapter {
    private $databaseTypeAdapter;
    public function __construct(DatabaseTypeAdapter $databaseTypeAdapter) {
        $this->databaseTypeAdapter = $databaseTypeAdapter;
    }

    public function fromTypeToType(Type $type) {
        $databaseType = $type->getDatabaseType();
        return new ConcreteAnnotationParameterType(false, false, $databaseType, $default);
    }

    public function fromObjectPropertyToType(Property $objectProperty) {

        $isUnique = $objectProperty->isUnique();
        $isKey = $objectProperty->isKey();

        $default = null;
        if ($objectProperty->hasDefault()) {
            $default = $objectProperty->getDefault();
        }

        $databaseType = null;
        $objectPropertyType = $objectProperty->getType();
        if ($objectPropertyType->hasType()) {
            $type = $objectPropertyType->getType();
            $databaseType = $type->getDatabaseType();
        }

        if ($objectPropertyType->hasObject()) {
            $databaseType = $this->databaseTypeAdapter->fromDataToDatabaseType([
                'name' => 'binary',
                'specific' => 128
            ]);
        }

        if ($objectPropertyType->hasPrimitive()) {
            $objectPropertyPrimitiveName = $objectPropertyType->getPrimitive()->getName();
            $databaseType = $this->databaseTypeAdapter->fromDataToDatabaseType([
                'name' => $objectPropertyPrimitiveName,
                'specific' => 255
            ]);
        }

        return new ConcreteAnnotationParameterType($isUnique, $isKey, $databaseType, $default);

    }

}
