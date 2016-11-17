<?php
namespace iRESTful\Rodson\Annotations\Infrastructure\Adapters;
use iRESTful\Rodson\Annotations\Domain\Parameters\Converters\Singles\Adapters\SingleConverterAdapter;
use iRESTful\Rodson\Classes\Domain\Namespaces\Adapters\InterfaceNamespaceAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\Annotations\Infrastructure\Objects\ConcreteAnnotationParameterConverterSingle;

final class ConcreteAnnotationParameterConverterSingleAdapter implements SingleConverterAdapter {
    private $namespaceAdapter;
    public function __construct(InterfaceNamespaceAdapter $namespaceAdapter) {
        $this->namespaceAdapter = $namespaceAdapter;
    }

    public function fromTypeToDatabaseSingleConverter(Type $type) {
        $methodName = $type->getDatabaseConverterMethodName();
        $namespace = $this->namespaceAdapter->fromTypeToAdapterNamespace($type);
        $interfaceName = $namespace->getAllAsString();
        return new ConcreteAnnotationParameterConverterSingle($interfaceName, $methodName);
    }

    public function fromTypeToViewSingleConverter(Type $type) {

        if (!$type->hasViewConverter()) {
            //throws
        }

        $methodName = $type->getViewConverterMethodName();
        $namespace = $this->namespaceAdapter->fromTypeToAdapterNamespace($type);
        $interfaceName = $namespace->getAllAsString();
        return new ConcreteAnnotationParameterConverterSingle($interfaceName, $methodName);
    }

}
