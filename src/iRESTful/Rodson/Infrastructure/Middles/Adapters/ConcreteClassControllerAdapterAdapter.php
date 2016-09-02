<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Controllers\Adapters\Adapters\ControllerAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassControllerAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionAssignmentAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionConversionAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseRetrievalAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionConversionFromAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionConversionToAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseRetrievalEntityAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseActionAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseActionInsertAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseActionUpdateAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseActionDeleteAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseRetrievalEntityPartialSetAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseRetrievalKeynameAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseRetrievalMultipleEntityAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInterfaceNamespaceAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInterfaceMethodParameterTypeAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInterfaceMethodParameterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassMethodCustomAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassPropertyAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassConstructorParameterMethodAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassConstructorParameterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassConstructorAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassNamespaceAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteValueAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionContainerAdapterAdapter;

final class ConcreteClassControllerAdapterAdapter implements ControllerAdapterAdapter {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function fromAnnotatedClassesToControllerAdapter(array $annotatedClasses) {

        //container:
        $valueAdapterAdapter = new ConcreteValueAdapterAdapter();
        $classInstructionContainerAdapterAdapter = new ConcreteClassInstructionContainerAdapterAdapter($valueAdapterAdapter);

        //instructions
        $classInstructionConversionFromAdapterAdapter = new ConcreteClassInstructionConversionFromAdapterAdapter();
        $classInstructionConversionToAdapterAdapter = new ConcreteClassInstructionConversionToAdapterAdapter($classInstructionContainerAdapterAdapter);
        $classInstructionConversionAdapterAdapter = new ConcreteClassInstructionConversionAdapterAdapter($classInstructionConversionFromAdapterAdapter, $classInstructionConversionToAdapterAdapter);

        $classInstructionDatabaseRetrievalKeynameAdapterAdapter = new ConcreteClassInstructionDatabaseRetrievalKeynameAdapterAdapter($valueAdapterAdapter);
        $classInstructionDatabaseRetrievalEntityAdapterAdapter = new ConcreteClassInstructionDatabaseRetrievalEntityAdapterAdapter($classInstructionDatabaseRetrievalKeynameAdapterAdapter, $valueAdapterAdapter, $classInstructionContainerAdapterAdapter);
        $classInstructionDatabaseRetrievalEntityPartialSetAdapterAdapter = new ConcreteClassInstructionDatabaseRetrievalEntityPartialSetAdapterAdapter($valueAdapterAdapter, $classInstructionContainerAdapterAdapter);
        $classInstructionDatabaseRetrievalMultipleEntityAdapterAdapter = new ConcreteClassInstructionDatabaseRetrievalMultipleEntityAdapterAdapter($classInstructionDatabaseRetrievalKeynameAdapterAdapter, $valueAdapterAdapter, $classInstructionContainerAdapterAdapter);

        $classInstructionDatabaseRetrievalAdapterAdapter = new ConcreteClassInstructionDatabaseRetrievalAdapterAdapter(
            $classInstructionDatabaseRetrievalEntityAdapterAdapter,
            $classInstructionDatabaseRetrievalEntityPartialSetAdapterAdapter,
            $classInstructionDatabaseRetrievalMultipleEntityAdapterAdapter
        );

        $classInstructionDatabaseActionInsertAdapterAdapter = new ConcreteClassInstructionDatabaseActionInsertAdapterAdapter();
        $classInstructionDatabaseActionUpdateAdapterAdapter = new ConcreteClassInstructionDatabaseActionUpdateAdapterAdapter();
        $classInstructionDatabaseActionDeleteAdapterAdapter = new ConcreteClassInstructionDatabaseActionDeleteAdapterAdapter();
        $classInstructionDatabaseActionAdapterAdapter = new ConcreteClassInstructionDatabaseActionAdapterAdapter(
            $classInstructionDatabaseActionInsertAdapterAdapter,
            $classInstructionDatabaseActionUpdateAdapterAdapter,
            $classInstructionDatabaseActionDeleteAdapterAdapter
        );


        $classInstructionDatabaseAdapterAdapter = new ConcreteClassInstructionDatabaseAdapterAdapter(
            $classInstructionDatabaseRetrievalAdapterAdapter,
            $classInstructionDatabaseActionAdapterAdapter
        );

        $classInstructionAssignmentAdapterAdapter = new ConcreteClassInstructionAssignmentAdapterAdapter(
            $classInstructionDatabaseAdapterAdapter,
            $classInstructionConversionAdapterAdapter
        );

        $classInstructionAdapterAdapter = new ConcreteClassInstructionAdapterAdapter(
            $classInstructionDatabaseActionAdapterAdapter,
            $classInstructionAssignmentAdapterAdapter
        );

        //custom method adapter
        $interfaceNamespaceAdapter = new ConcreteClassInterfaceNamespaceAdapter($this->baseNamespace);
        $interfaceMethodParamaterTypeAdapter = new ConcreteClassInterfaceMethodParameterTypeAdapter();
        $interfaceMethodParameterAdapter = new ConcreteClassInterfaceMethodParameterAdapter($interfaceNamespaceAdapter, $interfaceMethodParamaterTypeAdapter);
        $classCustomMethodAdapter = new ConcreteClassMethodCustomAdapter($interfaceMethodParameterAdapter);

        //constructor:
        $classPropertyAdapter = new ConcreteClassPropertyAdapter();
        $classConstructorParameterMethodAdapter = new ConcreteClassConstructorParameterMethodAdapter();
        $constructorParameterAdapter = new ConcreteClassConstructorParameterAdapter($interfaceNamespaceAdapter, $classPropertyAdapter, $interfaceMethodParameterAdapter, $classConstructorParameterMethodAdapter);
        $constructorAdapter = new ConcreteClassConstructorAdapter($constructorParameterAdapter, $classCustomMethodAdapter);

        //namespace
        $classNamespaceAdapter = new ConcreteClassNamespaceAdapter($this->baseNamespace);

        return new ConcreteClassControllerAdapter(
            $classInstructionAdapterAdapter,
            $classCustomMethodAdapter,
            $constructorAdapter,
            $classNamespaceAdapter,
            $annotatedClasses
        );
    }

}
