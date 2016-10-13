<?php
namespace iRESTful\Classes\Domain\Namespaces\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Object;
use iRESTful\DSLs\Domain\Projects\Types\Type;
use iRESTful\DSLs\Domain\Projects\Controllers\Controller;

interface InterfaceNamespaceAdapter {
    public function fromControllerToNamespace(Controller $controller);
    public function fromObjectToNamespace(Object $object);
    public function fromTypeToAdapterNamespace(Type $type);
    public function fromTypeToNamespace(Type $type);
    public function fromDataToNamespace(array $data);
}
