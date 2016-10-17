<?php
namespace iRESTful\Classes\Infrastructure\Adapters;
use iRESTful\Classes\Domain\Namespaces\Adapters\InterfaceNamespaceAdapter;
use iRESTful\Classes\Domain\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\DSLs\Domain\Projects\Objects\Object;
use iRESTful\DSLs\Domain\Projects\Types\Type;
use iRESTful\DSLs\Domain\Projects\Controllers\Controller;

final class ConcreteInterfaceNamespaceAdapter implements InterfaceNamespaceAdapter {
    private $namespaceAdapter;
    private $baseNamespace;
    public function __construct(NamespaceAdapter $namespaceAdapter) {
        $this->namespaceAdapter = $namespaceAdapter;
        $this->baseNamespace = 'Domain';
    }

    public function fromDataToNamespace(array $data) {
        $merged = array_merge([$this->baseNamespace], $data);
        return $this->namespaceAdapter->fromDataToNamespace($merged);
    }

    public function fromControllerToNamespace(Controller $controller) {
        $rootFolder = 'Controllers';
        $controllerName = $controller->getName();
        return $this->fromDataToNamespace([$rootFolder, $controllerName]);
    }

    public function fromObjectToNamespace(Object $object) {

        $rootFolder = 'Objects';
        if ($object->hasDatabase()) {
            $rootFolder = 'Entities';
        }

        $objectName = $object->getName();
        return $this->fromDataToNamespace([$rootFolder, $objectName]);

    }

    public function fromTypeToNamespace(Type $type) {
        $typeName = $type->getName();

        $folderName = $typeName;
        if (substr($folderName, -1) != 's') {
            $folderName = $folderName.'s';
        }

        return $this->fromDataToNamespace(['Types', $folderName, $typeName]);
    }

    public function fromTypeToAdapterNamespace(Type $type) {
        $typeName = $type->getName();

        $folderName = $typeName;
        if (substr($folderName, -1) != 's') {
            $folderName = $folderName.'s';
        }

        return $this->fromDataToNamespace(['Types', $folderName, 'Adapters', $typeName.'Adapter']);
    }

}
