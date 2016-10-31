<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Databases\Retrievals\Adapters\Adapters\RetrievalAdapterAdapter;
use iRESTful\Instructions\Domain\Databases\Retrievals\Entities\Adapters\Adapters\EntityAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseRetrievalAdapter;
use iRESTful\Instructions\Domain\Databases\Retrievals\EntityPartialSets\Adapters\Adapters\EntityPartialSetAdapterAdapter;
use iRESTful\Instructions\Domain\Databases\Retrievals\Multiples\Adapters\Adapters\MultipleEntityAdapterAdapter;
use iRESTful\Instructions\Domain\Databases\Retrievals\Relations\Adapters\Adapters\RelatedEntityAdapterAdapter;

final class ConcreteInstructionDatabaseRetrievalAdapterAdapter implements RetrievalAdapterAdapter {
    private $entityAdapterAdapter;
    private $entityPartialSetAdapterAdapter;
    private $multipleEntityAdapterAdapter;
    private $relatedEntityAdapterAdapter;
    public function __construct(
        EntityAdapterAdapter $entityAdapterAdapter,
        EntityPartialSetAdapterAdapter $entityPartialSetAdapterAdapter,
        MultipleEntityAdapterAdapter $multipleEntityAdapterAdapter,
        RelatedEntityAdapterAdapter $relatedEntityAdapterAdapter
    ) {
        $this->entityAdapterAdapter = $entityAdapterAdapter;
        $this->entityPartialSetAdapterAdapter = $entityPartialSetAdapterAdapter;
        $this->multipleEntityAdapterAdapter = $multipleEntityAdapterAdapter;
        $this->relatedEntityAdapterAdapter = $relatedEntityAdapterAdapter;
    }

    public function fromDataToRetrievalAdapter(array $data) {
        $entityAdapter = $this->entityAdapterAdapter->fromDataToEntityAdapter($data);
        $entityPartialSetAdapter = $this->entityPartialSetAdapterAdapter->fromDataToEntityPartialSetAdapter($data);
        $multipleEntityAdapter = $this->multipleEntityAdapterAdapter->fromDataToMultipleEntityAdapter($data);
        $relatedEntityAdapter = $this->relatedEntityAdapterAdapter->fromDataToRelatedEntityAdapter($data);
        return new ConcreteInstructionDatabaseRetrievalAdapter($entityAdapter, $entityPartialSetAdapter, $multipleEntityAdapter, $relatedEntityAdapter);
    }

}
