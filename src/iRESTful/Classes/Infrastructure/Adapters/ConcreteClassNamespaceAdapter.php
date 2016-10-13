<?php
namespace iRESTful\Classes\Infrastructure\Adapters;
use iRESTful\Classes\Domain\Namespaces\Adapters\ClassNamespaceAdapter;
use iRESTful\Classes\Domain\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\DSLs\Domain\Projects\Objects\Object;
use iRESTful\DSLs\Domain\Projects\Types\Type;
use iRESTful\DSLs\Domain\Projects\Controllers\Controller;

final class ConcreteClassNamespaceAdapter implements ClassNamespaceAdapter {
    private $namespaceAdapter;
    private $baseNamespace;
    public function __construct(NamespaceAdapter $namespaceAdapter) {
        $this->namespaceAdapter = $namespaceAdapter;
        $this->baseNamespace = 'Infrastructure';
    }

    public function fromDataToNamespace(array $data) {
        $merged = array_merge([$this->baseNamespace], $data);
        return $this->namespaceAdapter->fromDataToNamespace($merged);
    }

    public function fromControllerToNamespace(Controller $controller) {
        $rootFolder = 'Controllers';
        $controllerName = $controller->getName();
        return $this->fromDataToNamespace([$rootFolder, 'Concrete'.ucfirst($controllerName)]);
    }

    public function fromObjectToNamespace(Object $object) {

        $rootFolder = 'Objects';
        if ($object->hasDatabase()) {
            $rootFolder = 'Entities';
        }
        
        $objectName = $object->getName();
        return $this->fromDataToNamespace([$rootFolder, 'Concrete'.ucfirst($objectName)]);

    }

    public function fromTypeToNamespace(Type $type) {
        $typeName = $type->getName();
        return $this->fromDataToNamespace(['Types', 'Concrete'.ucfirst($typeName)]);
    }

    public function fromTypeToAdapterNamespace(Type $type) {
        $typeName = $type->getName();
        return $this->fromDataToNamespace(['Types', 'Adapters', 'Concrete'.ucfirst($typeName).'Adapter']);
    }

}
