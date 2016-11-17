<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Values\Adapters\Adapters\ValueAdapterAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteValueAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Values\Exceptions\ValueException;

final class ConcreteValueAdapterAdapter implements ValueAdapterAdapter {

    public function __construct() {

    }

    public function fromDataToValueAdapter(array $data) {
        $constants = empty($data['constants']) ? [] : $data['constants'];
        return new ConcreteValueAdapter($constants);
    }

}
