<?php
namespace iRESTful\Classes\Domain\Namespaces\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Object;
use iRESTful\DSLs\Domain\Projects\Types\Type;
use iRESTful\DSLs\Domain\Projects\Controllers\Controller;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Types\Parents\ParentObject;

interface InterfaceNamespaceAdapter {
    public function fromControllerToNamespace(Controller $controller);
    public function fromObjectToNamespace(Object $object);
    public function fromTypeToAdapterNamespace(Type $type);
    public function fromTypeToNamespace(Type $type);
    public function fromParentObjectToNamespace(ParentObject $parentObject);
    public function fromDataToNamespace(array $data);
    public function fromFullDataToNamespace(array $data);
}
