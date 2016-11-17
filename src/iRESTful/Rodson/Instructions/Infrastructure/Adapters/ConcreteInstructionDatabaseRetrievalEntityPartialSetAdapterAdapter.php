<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\EntityPartialSets\Adapters\Adapters\EntityPartialSetAdapterAdapter;
use iRESTful\Rodson\Instructions\Domain\Values\Adapters\Adapters\ValueAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseRetrievalEntityPartialSetAdapter;
use iRESTful\Rodson\Instructions\Domain\Containers\Adapters\Adapters\ContainerAdapterAdapter;

final class ConcreteInstructionDatabaseRetrievalEntityPartialSetAdapterAdapter implements EntityPartialSetAdapterAdapter {
    private $valueAdapterAdapter;
    private $containerAdapterAdapter;
    public function __construct(ValueAdapterAdapter $valueAdapterAdapter, ContainerAdapterAdapter $containerAdapterAdapter) {
        $this->valueAdapterAdapter = $valueAdapterAdapter;
        $this->containerAdapterAdapter = $containerAdapterAdapter;
    }

    public function fromDataToEntityPartialSetAdapter(array $data) {

        $constants = empty($data['constants']) ? [] : $data['constants'];
        $valueAdapter = $this->valueAdapterAdapter->fromDataToValueAdapter([
            'constants' => $constants
        ]);

        $containerAdapter = $this->containerAdapterAdapter->fromDataToContainerAdapter($data);
        return new ConcreteInstructionDatabaseRetrievalEntityPartialSetAdapter($valueAdapter, $containerAdapter);
    }

}
