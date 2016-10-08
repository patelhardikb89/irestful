<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Factories;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Adapters\Adapters\Factories\InstructionAdapterAdapterFactory;
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
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteValueAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionContainerAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionAdapterAdapter;

final class ConcreteClassInstructionAdapterAdapterFactory implements InstructionAdapterAdapterFactory {

    public function __construct() {

    }

    public function create() {

        $classInstructionDatabaseActionInsertAdapterAdapter = new ConcreteClassInstructionDatabaseActionInsertAdapterAdapter();
        $classInstructionDatabaseActionUpdateAdapterAdapter = new ConcreteClassInstructionDatabaseActionUpdateAdapterAdapter();
        $classInstructionDatabaseActionDeleteAdapterAdapter = new ConcreteClassInstructionDatabaseActionDeleteAdapterAdapter();
        $classInstructionDatabaseActionAdapterAdapter = new ConcreteClassInstructionDatabaseActionAdapterAdapter(
            $classInstructionDatabaseActionInsertAdapterAdapter,
            $classInstructionDatabaseActionUpdateAdapterAdapter,
            $classInstructionDatabaseActionDeleteAdapterAdapter
        );

        $valueAdapterAdapter = new ConcreteValueAdapterAdapter();
        $classInstructionContainerAdapterAdapter = new ConcreteClassInstructionContainerAdapterAdapter($valueAdapterAdapter);

        $classInstructionDatabaseRetrievalKeynameAdapterAdapter = new ConcreteClassInstructionDatabaseRetrievalKeynameAdapterAdapter($valueAdapterAdapter);
        $classInstructionDatabaseRetrievalEntityAdapterAdapter = new ConcreteClassInstructionDatabaseRetrievalEntityAdapterAdapter($classInstructionDatabaseRetrievalKeynameAdapterAdapter, $valueAdapterAdapter, $classInstructionContainerAdapterAdapter);
        $classInstructionDatabaseRetrievalEntityPartialSetAdapterAdapter = new ConcreteClassInstructionDatabaseRetrievalEntityPartialSetAdapterAdapter($valueAdapterAdapter, $classInstructionContainerAdapterAdapter);
        $classInstructionDatabaseRetrievalMultipleEntityAdapterAdapter = new ConcreteClassInstructionDatabaseRetrievalMultipleEntityAdapterAdapter($classInstructionDatabaseRetrievalKeynameAdapterAdapter, $valueAdapterAdapter, $classInstructionContainerAdapterAdapter);

        $classInstructionDatabaseRetrievalAdapterAdapter = new ConcreteClassInstructionDatabaseRetrievalAdapterAdapter(
            $classInstructionDatabaseRetrievalEntityAdapterAdapter,
            $classInstructionDatabaseRetrievalEntityPartialSetAdapterAdapter,
            $classInstructionDatabaseRetrievalMultipleEntityAdapterAdapter
        );

        $classInstructionDatabaseAdapterAdapter = new ConcreteClassInstructionDatabaseAdapterAdapter(
            $classInstructionDatabaseRetrievalAdapterAdapter,
            $classInstructionDatabaseActionAdapterAdapter
        );

        $classInstructionConversionFromAdapterAdapter = new ConcreteClassInstructionConversionFromAdapterAdapter();
        $classInstructionConversionToAdapterAdapter = new ConcreteClassInstructionConversionToAdapterAdapter($classInstructionContainerAdapterAdapter);
        $classInstructionConversionAdapterAdapter = new ConcreteClassInstructionConversionAdapterAdapter($classInstructionConversionFromAdapterAdapter, $classInstructionConversionToAdapterAdapter);

        $classInstructionAssignmentAdapterAdapter = new ConcreteClassInstructionAssignmentAdapterAdapter(
            $classInstructionDatabaseAdapterAdapter,
            $classInstructionConversionAdapterAdapter
        );

        return new ConcreteClassInstructionAdapterAdapter(
            $classInstructionDatabaseActionAdapterAdapter,
            $classInstructionAssignmentAdapterAdapter
        );
    }

}
