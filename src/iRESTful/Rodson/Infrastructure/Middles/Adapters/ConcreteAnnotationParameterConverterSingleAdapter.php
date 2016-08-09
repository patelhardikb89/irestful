<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Converters\Singles\Adapters\SingleConverterAdapter;
use iRESTful\Rodson\Domain\Middles\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteAnnotationParameterConverterSingle;

final class ConcreteAnnotationParameterConverterSingleAdapter implements SingleConverterAdapter {
    private $namespaceAdapter;
    public function __construct(NamespaceAdapter $namespaceAdapter) {
        $this->namespaceAdapter = $namespaceAdapter;
    }

    public function fromTypeToDatabaseSingleConverter(Type $type) {
        $methodName = $type->getDatabaseAdapterMethodName();
        $namespace = $this->namespaceAdapter->fromTypeToAdapterNamespace($type);
        $interfaceName = $namespace->getAllAsString();
        return new ConcreteAnnotationParameterConverterSingle($interfaceName, $methodName);
    }

    public function fromTypeToViewSingleConverter(Type $type) {

        if (!$type->hasViewAdapter()) {
            //throws
        }

        $methodName = $type->getViewAdapterMethodName();
        $namespace = $this->namespaceAdapter->fromTypeToAdapterNamespace($type);
        $interfaceName = $namespace->getAllAsString();
        return new ConcreteAnnotationParameterConverterSingle($interfaceName, $methodName);
    }

}
