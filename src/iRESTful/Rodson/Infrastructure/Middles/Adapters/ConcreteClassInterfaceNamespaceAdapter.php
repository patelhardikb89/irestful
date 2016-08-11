<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\AbstractNamespaceAdapter;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Controllers\Controller;

final class ConcreteClassInterfaceNamespaceAdapter extends AbstractNamespaceAdapter implements NamespaceAdapter {

    public function __construct(array $baseNamespace) {
        $baseNamespace = array_merge($baseNamespace, ['Domain']);
        parent::__construct($baseNamespace);
    }

    public function fromControllerToNamespace(Controller $controller) {
        $rootFolder = 'Controllers';
        $controllerName = $controller->getName();
        $name = $this->convert($controllerName);
        return $this->fromDataToNamespace([$rootFolder, $name]);
    }

    public function fromObjectToNamespace(Object $object) {

        $rootFolder = 'Objects';
        if ($object->hasDatabase()) {
            $rootFolder = 'Entities';
        }

        $objectName = $object->getName();
        $name = $this->convert($objectName);
        return $this->fromDataToNamespace([$rootFolder, $name]);

    }

    public function fromTypeToNamespace(Type $type) {
        $typeName = $type->getName();
        $name = $this->convert($typeName);

        $folderName = $name;
        if (substr($name, -1) != 's') {
            $folderName = $folderName.'s';
        }

        return $this->fromDataToNamespace(['Types', $folderName, $name]);
    }

    public function fromTypeToAdapterNamespace(Type $type) {
        $typeName = $type->getName();
        $name = $this->convert($typeName);

        $folderName = $name;
        if (substr($name, -1) != 's') {
            $folderName = $folderName.'s';
        }

        return $this->fromDataToNamespace(['Types', $folderName, 'Adapters', $name.'Adapter']);
    }

}
