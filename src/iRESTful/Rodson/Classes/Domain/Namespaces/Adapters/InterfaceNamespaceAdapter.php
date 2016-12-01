<?php
namespace iRESTful\Rodson\Classes\Domain\Namespaces\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Controller;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Properties\Types\Parents\ParentObject;

interface InterfaceNamespaceAdapter {
    public function fromControllerToNamespace(Controller $controller);
    public function fromObjectToNamespace(Object $object);
    public function fromTypeToAdapterNamespace(Type $type);
    public function fromObjectToAdapterNamespace(Object $object);
    public function fromTypeToNamespace(Type $type);
    public function fromParentObjectToNamespace(ParentObject $parentObject);
    public function fromDataToNamespace(array $data);
    public function fromFullDataToNamespace(array $data);
}
