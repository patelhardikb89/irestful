<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Multiples\Adapters\Adapters\MultipleEntityAdapterAdapter;
use iRESTful\Rodson\Domain\Inputs\Values\Adapters\Adapters\ValueAdapterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Keynames\Adapters\Adapters\KeynameAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseRetrievalMultipleEntityAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Adapters\Adapters\ContainerAdapterAdapter;

final class ConcreteClassInstructionDatabaseRetrievalMultipleEntityAdapterAdapter implements MultipleEntityAdapterAdapter {
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

    public function fromDataToMultipleEntityAdapter(array $data) {

        $constants = empty($data['constants']) ? [] : $data['constants'];
        $valueAdapter = $this->valueAdapterAdapter->fromDataToValueAdapter([
            'constants' => $constants
        ]);

        $keynameAdapter = $this->keynameAdapterAdapter->fromDataToKeynameAdapter([
            'constants' => $constants
        ]);

        $containerAdapter = $this->containerAdapterAdapter->fromDataToContainerAdapter($data);
        return new ConcreteClassInstructionDatabaseRetrievalMultipleEntityAdapter($keynameAdapter, $valueAdapter, $containerAdapter);
    }

}
