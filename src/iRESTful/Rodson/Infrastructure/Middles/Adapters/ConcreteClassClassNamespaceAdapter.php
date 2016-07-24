<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteNamespace;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassNamespace;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\AbstractClassNamespaceAdapter;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;

final class ConcreteClassClassNamespaceAdapter extends AbstractClassNamespaceAdapter implements NamespaceAdapter {

    public function __construct(array $baseNamespace) {
        $baseNamespace = array_merge($baseNamespace, ['Infrastructure']);
        parent::__construct($baseNamespace);
    }

    public function fromObjectToNamespace(Object $object) {

        $rootFolder = 'Objects';
        if ($object->hasDatabase()) {
            $rootFolder = 'Entities';
        }

        $objectName = $object->getName();
        $name = $this->convert($objectName);
        return $this->fromDataToNamespace([$rootFolder, 'Concrete'.$name]);

    }

    public function fromTypeToNamespace(Type $type) {
        $typeName = $type->getName();
        $name = $this->convert($typeName);

        return $this->fromDataToNamespace(['Types', 'Concrete'.$name]);
    }

    public function fromTypeToAdapterNamespace(Type $type) {

        $typeName = $type->getName();
        $name = $this->convert($typeName);

        return $this->fromDataToNamespace(['Types', 'Adapters', 'Concrete'.$name.'Adapter']);
    }

}
