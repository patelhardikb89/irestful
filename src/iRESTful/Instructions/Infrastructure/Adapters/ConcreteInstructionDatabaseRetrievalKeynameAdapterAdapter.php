<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Databases\Retrievals\Keynames\Adapters\Adapters\KeynameAdapterAdapter;
use iRESTful\Instructions\Domain\Values\Adapters\Adapters\ValueAdapterAdapter;
use iRESTful\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseRetrievalKeynameAdapter;

final class ConcreteInstructionDatabaseRetrievalKeynameAdapterAdapter implements KeynameAdapterAdapter {
    private $valueAdapterAdapter;
    public function __construct(ValueAdapterAdapter $valueAdapterAdapter) {
        $this->valueAdapterAdapter = $valueAdapterAdapter;
    }

    public function fromDataToKeynameAdapter(array $data) {
        $valueAdapter = $this->valueAdapterAdapter->fromDataToValueAdapter($data);
        return new ConcreteInstructionDatabaseRetrievalKeynameAdapter($valueAdapter);
    }

}
