<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Multiples\Adapters\Adapters\MultipleEntityAdapterAdapter;
use iRESTful\Rodson\Domain\Inputs\Values\Adapters\Adapters\ValueAdapterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Keynames\Adapters\Adapters\KeynameAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionDatabaseRetrievalMultipleEntityAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Multiples\Exceptions\MultipleEntityException;

final class ConcreteClassInstructionDatabaseRetrievalMultipleEntityAdapterAdapter implements MultipleEntityAdapterAdapter {
    private $keynameAdapterAdapter;
    private $valueAdapterAdapter;
    public function __construct(KeynameAdapterAdapter $keynameAdapterAdapter, ValueAdapterAdapter $valueAdapterAdapter) {
        $this->keynameAdapterAdapter = $keynameAdapterAdapter;
        $this->valueAdapterAdapter = $valueAdapterAdapter;
    }

    public function fromDataToMultipleEntityAdapter(array $data) {
        
        if (!isset($data['annotated_classes'])) {
            throw new MultipleEntityException('The annotated_classes keyname is mandatory in order to convert data to an EntityAdapter object.');
        }

        $constants = empty($data['constants']) ? [] : $data['constants'];
        $valueAdapter = $this->valueAdapterAdapter->fromDataToValueAdapter([
            'constants' => $constants
        ]);

        $keynameAdapter = $this->keynameAdapterAdapter->fromDataToKeynameAdapter([
            'constants' => $constants
        ]);

        return new ConcreteClassInstructionDatabaseRetrievalMultipleEntityAdapter($keynameAdapter, $valueAdapter, $data['annotated_classes']);
    }

}
