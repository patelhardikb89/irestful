<?php
namespace iRESTful\Classes\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Property;
use iRESTful\DSLs\Domain\Projects\Types\Type;
use iRESTful\Classes\Infrastructure\Objects\ConcreteClassConstructorParameterMethod;
use iRESTful\Classes\Domain\Constructors\Parameters\Methods\Adapters\MethodAdapter;

final class ConcreteClassConstructorParameterMethodAdapter implements MethodAdapter {

    public function __construct() {

    }

    public function fromPropertyToMethod(Property $property) {

        $convert = function($propertyName) {

            $matches = [];
            preg_match_all('/\_[\s\S]{1}/s', $propertyName, $matches);

            foreach($matches[0] as $oneElement) {
                $replacement = strtoupper(str_replace('_', '', $oneElement));
                $propertyName = str_replace($oneElement, $replacement, $propertyName);
            }

            return 'get'.ucfirst($propertyName);

        };

        $propertyName = $convert($property->getName());

        $subMethod = null;
        $propertyType = $property->getType();
        if ($propertyType->hasType()) {
            $propertyTypeType = $propertyType->getType();
            $subMethod = $this->fromTypeToMethod($propertyTypeType);
        }

        return new ConcreteClassConstructorParameterMethod($propertyName, $subMethod);
    }

    public function fromTypeToMethod(Type $type) {
        return new ConcreteClassConstructorParameterMethod('get');
    }

}
