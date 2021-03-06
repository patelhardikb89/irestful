<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Multiples\Adapters\Adapters\MultipleEntityAdapterAdapter;
use iRESTful\Rodson\Instructions\Domain\Values\Adapters\Adapters\ValueAdapterAdapter;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Keynames\Adapters\Adapters\KeynameAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionDatabaseRetrievalMultipleEntityAdapter;
use iRESTful\Rodson\Instructions\Domain\Containers\Adapters\Adapters\ContainerAdapterAdapter;

final class ConcreteInstructionDatabaseRetrievalMultipleEntityAdapterAdapter implements MultipleEntityAdapterAdapter {
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
        return new ConcreteInstructionDatabaseRetrievalMultipleEntityAdapter($keynameAdapter, $valueAdapter, $containerAdapter);
    }

}
