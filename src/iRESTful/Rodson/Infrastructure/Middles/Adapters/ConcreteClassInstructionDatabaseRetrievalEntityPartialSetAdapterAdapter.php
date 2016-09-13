<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets\Adapters\Adapters\EntityPartialSetAdapterAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Values\Adapters\Adapters\ValueAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseRetrievalEntityPartialSetAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Adapters\Adapters\ContainerAdapterAdapter;

final class ConcreteClassInstructionDatabaseRetrievalEntityPartialSetAdapterAdapter implements EntityPartialSetAdapterAdapter {
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
        return new ConcreteClassInstructionDatabaseRetrievalEntityPartialSetAdapter($valueAdapter, $containerAdapter);
    }

}
