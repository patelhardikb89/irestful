<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Adapters\Adapters\RetrievalAdapterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Entities\Adapters\Adapters\EntityAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseRetrievalAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets\Adapters\Adapters\EntityPartialSetAdapterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Multiples\Adapters\Adapters\MultipleEntityAdapterAdapter;

final class ConcreteClassInstructionDatabaseRetrievalAdapterAdapter implements RetrievalAdapterAdapter {
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
        return new ConcreteClassInstructionDatabaseRetrievalAdapter($entityAdapter, $entityPartialSetAdapter, $multipleEntityAdapter);
    }

}
