<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Namespaces\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type as PropertyType;

interface NamespaceAdapter {
    public function fromPropertyTypeToNamespace(PropertyType $propertyType);
    public function fromObjectToNamespace(Object $object);
    public function fromTypeToAdapterNamespace(Type $type);
    public function fromTypeToNamespace(Type $type);

}
