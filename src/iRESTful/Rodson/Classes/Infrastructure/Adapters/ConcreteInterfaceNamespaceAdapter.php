<?php
namespace iRESTful\Rodson\Classes\Infrastructure\Adapters;
use iRESTful\Rodson\Classes\Domain\Namespaces\Adapters\InterfaceNamespaceAdapter;
use iRESTful\Rodson\Classes\Domain\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Controller;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Properties\Types\Parents\ParentObject;

final class ConcreteInterfaceNamespaceAdapter implements InterfaceNamespaceAdapter {
    private $namespaceAdapter;
    private $baseNamespace;
    public function __construct(NamespaceAdapter $namespaceAdapter) {
        $this->namespaceAdapter = $namespaceAdapter;
        $this->baseNamespace = 'Domain';
    }

    public function fromFullDataToNamespace(array $data) {
        return $this->namespaceAdapter->fromFullDataToNamespace($data);
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

    public function fromObjectToAdapterNamespace(Object $object) {
        $objectName = $object->getName();

        $folderName = $objectName;
        if (substr($folderName, -1) != 's') {
            $folderName = $folderName.'s';
        }

        return $this->fromDataToNamespace(['Objects', $folderName, 'Adapters', $objectName.'Adapter']);
    }

    public function fromParentObjectToNamespace(ParentObject $parentObject) {
        $dslName = $parentObject->getSubDSL()->getDSL()->getName();
        $rootFolder = 'Entities';
        $objectName = $parentObject->getObject()->getName();

        return $this->fromFullDataToNamespace([
            $dslName->getOrganizationName(),
            $dslName->getProjectName(),
            $this->baseNamespace,
            $rootFolder,
            $this->convert($objectName)
        ]);
    }

    protected function convert($name) {
        $matches = [];
        preg_match_all('/\_[\s\S]{1}/s', $name, $matches);

        foreach($matches[0] as $oneElement) {
            $replacement = strtoupper(str_replace('_', '', $oneElement));
            $name = str_replace($oneElement, $replacement, $name);
        }

        return ucfirst($name);
    }

}
