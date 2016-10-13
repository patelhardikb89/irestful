<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Databases\Retrievals\Adapters\Adapters\RetrievalAdapterAdapter;
use iRESTful\Instructions\Domain\Databases\Retrievals\Entities\Adapters\Adapters\EntityAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseRetrievalAdapter;
use iRESTful\Instructions\Domain\Databases\Retrievals\EntityPartialSets\Adapters\Adapters\EntityPartialSetAdapterAdapter;
use iRESTful\Instructions\Domain\Databases\Retrievals\Multiples\Adapters\Adapters\MultipleEntityAdapterAdapter;

final class ConcreteInstructionDatabaseRetrievalAdapterAdapter implements RetrievalAdapterAdapter {
    private $entityAdapterAdapter;
    private $entityPartialSetAdapterAdapter;
    private $multipleEntityAdapterAdapter;
    public function __construct(
        EntityAdapterAdapter $entityAdapterAdapter,
        EntityPartialSetAdapterAdapter $entityPartialSetAdapterAdapter,
        MultipleEntityAdapterAdapter $multipleEntityAdapterAdapter
    ) {
        $this->entityAdapterAdapter = $entityAdapterAdapter;
        $this->entityPartialSetAdapterAdapter = $entityPartialSetAdapterAdapter;
        $this->multipleEntityAdapterAdapter = $multipleEntityAdapterAdapter;
    }

    public function fromDataToRetrievalAdapter(array $data) {
        $entityAdapter = $this->entityAdapterAdapter->fromDataToEntityAdapter($data);
        $entityPartialSetAdapter = $this->entityPartialSetAdapterAdapter->fromDataToEntityPartialSetAdapter($data);
        $multipleEntityAdapter = $this->multipleEntityAdapterAdapter->fromDataToMultipleEntityAdapter($data);
        return new ConcreteInstructionDatabaseRetrievalAdapter($entityAdapter, $entityPartialSetAdapter, $multipleEntityAdapter);
    }

}
