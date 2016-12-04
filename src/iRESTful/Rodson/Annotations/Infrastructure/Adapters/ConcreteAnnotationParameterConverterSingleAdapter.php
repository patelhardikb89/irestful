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
        $functionName = $type->getDatabaseConverterFunctionName();
        $namespace = $this->namespaceAdapter->fromTypeToAdapterNamespace($type);
        $interfaceName = $namespace->getAllAsString();
        return new ConcreteAnnotationParameterConverterSingle($interfaceName, $functionName);
    }

    public function fromTypeToViewSingleConverter(Type $type) {

        if (!$type->hasViewConverter()) {
            //throws
        }

        $functionName = $type->getViewConverterFunctionName();
        $namespace = $this->namespaceAdapter->fromTypeToAdapterNamespace($type);
        $interfaceName = $namespace->getAllAsString();
        return new ConcreteAnnotationParameterConverterSingle($interfaceName, $functionName);
    }

}
