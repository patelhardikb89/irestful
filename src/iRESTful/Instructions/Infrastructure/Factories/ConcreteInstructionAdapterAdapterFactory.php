<?php
namespace iRESTful\Instructions\Infrastructure\Factories;
use iRESTful\Instructions\Domain\Adapters\Adapters\Factories\InstructionAdapterAdapterFactory;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionAssignmentAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionConversionAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseRetrievalAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionConversionFromAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionConversionToAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseRetrievalEntityAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseActionAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseActionInsertAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseActionUpdateAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseActionDeleteAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseRetrievalEntityPartialSetAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseRetrievalKeynameAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseRetrievalMultipleEntityAdapterAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteValueAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionContainerAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionValueAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionValueLoopAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionValueLoopKeynameAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionValueLoopKeynameMetaDataAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionValueLoopKeynameMetaDataPropertyAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseRetrievalRelatedEntityAdapterAdapter;

final class ConcreteInstructionAdapterAdapterFactory implements InstructionAdapterAdapterFactory {

    public function __construct() {

    }

    public function create() {

        $classInstructionDatabaseActionInsertAdapterAdapter = new ConcreteInstructionDatabaseActionInsertAdapterAdapter();
        $classInstructionDatabaseActionUpdateAdapterAdapter = new ConcreteInstructionDatabaseActionUpdateAdapterAdapter();
        $classInstructionDatabaseActionDeleteAdapterAdapter = new ConcreteInstructionDatabaseActionDeleteAdapterAdapter();
        $classInstructionDatabaseActionAdapterAdapter = new ConcreteInstructionDatabaseActionAdapterAdapter(
            $classInstructionDatabaseActionInsertAdapterAdapter,
            $classInstructionDatabaseActionUpdateAdapterAdapter,
            $classInstructionDatabaseActionDeleteAdapterAdapter
        );

        $valueAdapterAdapter = new ConcreteValueAdapterAdapter();

        $propertyAdapter = new ConcreteInstructionValueLoopKeynameMetaDataPropertyAdapter();
        $metaDataAdapter = new ConcreteInstructionValueLoopKeynameMetaDataAdapter($propertyAdapter);
        $keynameAdapter = new ConcreteInstructionValueLoopKeynameAdapter($metaDataAdapter);
        $loopAdapter = new ConcreteInstructionValueLoopAdapter($keynameAdapter);
        $instructionValueAdapterAdapter = new ConcreteInstructionValueAdapterAdapter($loopAdapter, $valueAdapterAdapter);
        $classInstructionContainerAdapterAdapter = new ConcreteInstructionContainerAdapterAdapter($instructionValueAdapterAdapter);

        $classInstructionDatabaseRetrievalKeynameAdapterAdapter = new ConcreteInstructionDatabaseRetrievalKeynameAdapterAdapter($instructionValueAdapterAdapter);
        $classInstructionDatabaseRetrievalEntityAdapterAdapter = new ConcreteInstructionDatabaseRetrievalEntityAdapterAdapter($classInstructionDatabaseRetrievalKeynameAdapterAdapter, $instructionValueAdapterAdapter, $classInstructionContainerAdapterAdapter);
        $classInstructionDatabaseRetrievalEntityPartialSetAdapterAdapter = new ConcreteInstructionDatabaseRetrievalEntityPartialSetAdapterAdapter($instructionValueAdapterAdapter, $classInstructionContainerAdapterAdapter);
        $classInstructionDatabaseRetrievalMultipleEntityAdapterAdapter = new ConcreteInstructionDatabaseRetrievalMultipleEntityAdapterAdapter($classInstructionDatabaseRetrievalKeynameAdapterAdapter, $instructionValueAdapterAdapter, $classInstructionContainerAdapterAdapter);
        $classInstructionDatabaseRetrievalRelatedEntityAdapterAdapter = new ConcreteInstructionDatabaseRetrievalRelatedEntityAdapterAdapter($instructionValueAdapterAdapter, $classInstructionContainerAdapterAdapter);

        $classInstructionDatabaseRetrievalAdapterAdapter = new ConcreteInstructionDatabaseRetrievalAdapterAdapter(
            $classInstructionDatabaseRetrievalEntityAdapterAdapter,
            $classInstructionDatabaseRetrievalEntityPartialSetAdapterAdapter,
            $classInstructionDatabaseRetrievalMultipleEntityAdapterAdapter,
            $classInstructionDatabaseRetrievalRelatedEntityAdapterAdapter
        );

        $classInstructionDatabaseAdapterAdapter = new ConcreteInstructionDatabaseAdapterAdapter(
            $classInstructionDatabaseRetrievalAdapterAdapter,
            $classInstructionDatabaseActionAdapterAdapter
        );

        $classInstructionConversionFromAdapterAdapter = new ConcreteInstructionConversionFromAdapterAdapter();
        $classInstructionConversionToAdapterAdapter = new ConcreteInstructionConversionToAdapterAdapter($classInstructionContainerAdapterAdapter);
        $classInstructionConversionAdapterAdapter = new ConcreteInstructionConversionAdapterAdapter($classInstructionConversionFromAdapterAdapter, $classInstructionConversionToAdapterAdapter);

        $classInstructionAssignmentAdapterAdapter = new ConcreteInstructionAssignmentAdapterAdapter(
            $classInstructionDatabaseAdapterAdapter,
            $classInstructionConversionAdapterAdapter
        );

        return new ConcreteInstructionAdapterAdapter(
            $classInstructionDatabaseActionAdapterAdapter,
            $classInstructionAssignmentAdapterAdapter
        );
    }

}
