<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Keynames\Adapters\Adapters\KeynameAdapterAdapter;
use iRESTful\Rodson\Instructions\Domain\Values\Adapters\Adapters\ValueAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseRetrievalKeynameAdapter;

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
