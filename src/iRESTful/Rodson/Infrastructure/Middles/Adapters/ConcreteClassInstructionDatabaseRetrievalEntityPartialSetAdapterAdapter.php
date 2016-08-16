<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets\Adapters\Adapters\EntityPartialSetAdapterAdapter;
use iRESTful\Rodson\Domain\Inputs\Values\Adapters\Adapters\ValueAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseRetrievalEntityPartialSetAdapter;

final class ConcreteClassInstructionDatabaseRetrievalEntityPartialSetAdapterAdapter implements EntityPartialSetAdapterAdapter {
    private $valueAdapterAdapter;
    public function __construct(ValueAdapterAdapter $valueAdapterAdapter) {
        $this->valueAdapterAdapter = $valueAdapterAdapter;
    }

    public function fromDataToEntityPartialSetAdapter(array $data) {
        if (!isset($data['constants'])) {
            throw new EntityException('The constants keyname is mandatory in order to convert data to an EntityAdapter object.');
        }

        if (!isset($data['classes'])) {
            throw new EntityException('The classes keyname is mandatory in order to convert data to an EntityAdapter object.');
        }

        $valueAdapter = $this->valueAdapterAdapter->fromDataToValueAdapter([
            'constants' => $data['constants']
        ]);

        return new ConcreteClassInstructionDatabaseRetrievalEntityPartialSetAdapter($valueAdapter, $data['classes']);
    }

}
