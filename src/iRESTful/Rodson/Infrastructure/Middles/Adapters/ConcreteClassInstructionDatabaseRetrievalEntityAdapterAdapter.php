<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Entities\Adapters\Adapters\EntityAdapterAdapter;
use iRESTful\Rodson\Domain\Inputs\Values\Adapters\Adapters\ValueAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseRetrievalEntityAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Entities\Exceptions\EntityException;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Keynames\Adapters\Adapters\KeynameAdapterAdapter;

final class ConcreteClassInstructionDatabaseRetrievalEntityAdapterAdapter implements EntityAdapterAdapter {
    private $keynameAdapterAdapter;
    private $valueAdapterAdapter;
    public function __construct(KeynameAdapterAdapter $keynameAdapterAdapter, ValueAdapterAdapter $valueAdapterAdapter) {
        $this->keynameAdapterAdapter = $keynameAdapterAdapter;
        $this->valueAdapterAdapter = $valueAdapterAdapter;
    }

    public function fromDataToEntityAdapter(array $data) {

        if (!isset($data['constants'])) {
            throw new EntityException('The constants keyname is mandatory in order to convert data to an EntityAdapter object.');
        }

        if (!isset($data['classes'])) {
            throw new EntityException('The classes keyname is mandatory in order to convert data to an EntityAdapter object.');
        }

        $valueAdapter = $this->valueAdapterAdapter->fromDataToValueAdapter([
            'constants' => $data['constants']
        ]);

        $keynameAdapter = $this->keynameAdapterAdapter->fromDataToKeynameAdapter([
            'constants' => $data['constants']
        ]);

        return new ConcreteClassInstructionDatabaseRetrievalEntityAdapter($keynameAdapter, $valueAdapter, $data['classes']);

    }

}
