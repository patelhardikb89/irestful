<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets\Adapters\Adapters\EntityPartialSetAdapterAdapter;
use iRESTful\Rodson\Domain\Inputs\Values\Adapters\Adapters\ValueAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseRetrievalEntityPartialSetAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets\Exceptions\EntityPartialSetException;

final class ConcreteClassInstructionDatabaseRetrievalEntityPartialSetAdapterAdapter implements EntityPartialSetAdapterAdapter {
    private $valueAdapterAdapter;
    public function __construct(ValueAdapterAdapter $valueAdapterAdapter) {
        $this->valueAdapterAdapter = $valueAdapterAdapter;
    }

    public function fromDataToEntityPartialSetAdapter(array $data) {

        if (!isset($data['annotated_classes'])) {
            throw new EntityPartialSetException('The annotated_classes keyname is mandatory in order to convert data to an EntityAdapter object.');
        }

        $constants = empty($data['constants']) ? [] : $data['constants'];
        $valueAdapter = $this->valueAdapterAdapter->fromDataToValueAdapter([
            'constants' => $constants
        ]);

        return new ConcreteClassInstructionDatabaseRetrievalEntityPartialSetAdapter($valueAdapter, $data['annotated_classes']);
    }

}
