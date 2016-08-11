<?php
namespace iRESTful\Rodson\Domain\Middles\Namespaces\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type as PropertyType;
use iRESTful\Rodson\Domain\Inputs\Controllers\Controller;

interface NamespaceAdapter {
    public function fromControllerToNamespace(Controller $controller);
    public function fromPropertyTypeToNamespace(PropertyType $propertyType);
    public function fromObjectToNamespace(Object $object);
    public function fromTypeToAdapterNamespace(Type $type);
    public function fromTypeToNamespace(Type $type);
}
