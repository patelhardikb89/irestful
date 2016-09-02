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
        
        if (!isset($data['annotated_classes'])) {
            throw new EntityException('The annotated_classes keyname is mandatory in order to convert data to an EntityAdapter object.');
        }

        $constants = !empty($data['constants']) ? [] : $data['constants'];
        $valueAdapter = $this->valueAdapterAdapter->fromDataToValueAdapter([
            'constants' => $constants
        ]);

        $keynameAdapter = $this->keynameAdapterAdapter->fromDataToKeynameAdapter([
            'constants' => $constants
        ]);

        return new ConcreteClassInstructionDatabaseRetrievalEntityAdapter($keynameAdapter, $valueAdapter, $data['annotated_classes']);

    }

}
