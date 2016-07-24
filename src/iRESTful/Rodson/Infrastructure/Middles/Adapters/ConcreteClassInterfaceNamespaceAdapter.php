<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\AbstractClassNamespaceAdapter;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;

final class ConcreteClassInterfaceNamespaceAdapter extends AbstractClassNamespaceAdapter implements NamespaceAdapter {

    public function __construct(array $baseNamespace) {
        $baseNamespace = array_merge($baseNamespace, ['Domain']);
        parent::__construct($baseNamespace);
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

        return $this->fromDataToNamespace(['Types', $name]);
    }

    public function fromTypeToAdapterNamespace(Type $type) {
        $typeName = $type->getName();
        $name = $this->convert($typeName);

        return $this->fromDataToNamespace(['Types', $name, 'Adapters', $name.'Adapter']);
    }

}
