<?php
namespace iRESTful\Rodson\Infrastructure\Factories;
use iRESTful\Rodson\Domain\Services\Factories\RodsonServiceFactory;
use iRESTful\Rodson\Infrastructure\Services\FileRodsonService;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteClassAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteClassPropertyAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteMethodAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteMethodParameterAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteMethodReturnedInterfaceAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteNamespaceAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteInterfaceAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\PHPCodeAdapter;
use iRESTful\Rodson\Infrastructure\Services\FileCodeService;
use iRESTful\Rodson\Infrastructure\Adapters\PHPClassMethodAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteOutputCodePathAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteOutputCodeFileAdapter;

final class PHPFileRodsonServiceFactory implements RodsonServiceFactory {
    private $interfaceBaseNamespace;
    private $classBaseNamespace;
    private $baseFilePath;
    public function __construct(array $interfaceBaseNamespace, array $classBaseNamespace, array $baseFilePath) {
        $this->interfaceBaseNamespace = $interfaceBaseNamespace;
        $this->classBaseNamespace = $classBaseNamespace;
        $this->baseFilePath = $baseFilePath;
    }

    public function create() {

        $interfaceNamespaceAdapter = new ConcreteNamespaceAdapter($this->interfaceBaseNamespace);
        $classNamespaceAdapter = new ConcreteNamespaceAdapter($this->classBaseNamespace);

        $returnedInterfaceAdapter = new ConcreteMethodReturnedInterfaceAdapter($interfaceNamespaceAdapter);
        $parameterAdapter = new ConcreteMethodParameterAdapter($returnedInterfaceAdapter);
        $methodAdapter = new ConcreteMethodAdapter($returnedInterfaceAdapter, $parameterAdapter);
        $propertyAdapter = new ConcreteClassPropertyAdapter();
        $interfaceAdapter = new ConcreteInterfaceAdapter($methodAdapter, $interfaceNamespaceAdapter);

        $classMethodAdapter = new PHPClassMethodAdapter($parameterAdapter, $methodAdapter, $propertyAdapter);
        $classAdapter = new ConcreteClassAdapter($classNamespaceAdapter, $interfaceAdapter, $classMethodAdapter, $propertyAdapter);

        $fileAdapter = new ConcreteOutputCodeFileAdapter();
        $pathAdapter = new ConcreteOutputCodePathAdapter($fileAdapter, $this->baseFilePath);
        $codeAdapter = new PHPCodeAdapter($pathAdapter);
        $codeService = new FileCodeService();

        return new FileRodsonService($classAdapter, $codeAdapter, $codeService);

    }

}
