<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Factories;
use iRESTful\Rodson\Instructions\Domain\Adapters\Adapters\Factories\InstructionAdapterAdapterFactory;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionAssignmentAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionConversionAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseRetrievalAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionConversionFromAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionConversionToAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseRetrievalEntityAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseActionAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseActionInsertAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseActionUpdateAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseActionDeleteAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseRetrievalEntityPartialSetAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseRetrievalKeynameAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseRetrievalMultipleEntityAdapterAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteValueAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionContainerAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionValueAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionValueLoopAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionValueLoopKeynameAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionValueLoopKeynameMetaDataAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionValueLoopKeynameMetaDataPropertyAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseRetrievalRelatedEntityAdapterAdapter;

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
