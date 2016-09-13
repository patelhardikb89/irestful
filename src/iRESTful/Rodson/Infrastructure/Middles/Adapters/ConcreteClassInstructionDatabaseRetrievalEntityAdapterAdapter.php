<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Entities\Adapters\Adapters\EntityAdapterAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Values\Adapters\Adapters\ValueAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseRetrievalEntityAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Keynames\Adapters\Adapters\KeynameAdapterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Adapters\Adapters\ContainerAdapterAdapter;

final class ConcreteClassInstructionDatabaseRetrievalEntityAdapterAdapter implements EntityAdapterAdapter {
    private $keynameAdapterAdapter;
    private $valueAdapterAdapter;
    private $containerAdapterAdapter;
    public function __construct(
        KeynameAdapterAdapter $keynameAdapterAdapter,
        ValueAdapterAdapter $valueAdapterAdapter,
        ContainerAdapterAdapter $containerAdapterAdapter
    ) {
        $this->keynameAdapterAdapter = $keynameAdapterAdapter;
        $this->valueAdapterAdapter = $valueAdapterAdapter;
        $this->containerAdapterAdapter = $containerAdapterAdapter;
    }

    public function fromDataToEntityAdapter(array $data) {
        
        $constants = !empty($data['constants']) ? [] : $data['constants'];
        $valueAdapter = $this->valueAdapterAdapter->fromDataToValueAdapter([
            'constants' => $constants
        ]);

        $keynameAdapter = $this->keynameAdapterAdapter->fromDataToKeynameAdapter([
            'constants' => $constants
        ]);

        $containerAdapter = $this->containerAdapterAdapter->fromDataToContainerAdapter($data);
        return new ConcreteClassInstructionDatabaseRetrievalEntityAdapter($keynameAdapter, $valueAdapter, $containerAdapter);

    }

}
