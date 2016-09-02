<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Values\Adapters\Adapters\ValueAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteValueAdapter;
use iRESTful\Rodson\Domain\Inputs\Values\Exceptions\ValueException;

final class ConcreteValueAdapterAdapter implements ValueAdapterAdapter {

    public function __construct() {

    }

    public function fromDataToValueAdapter(array $data) {
        $constants = empty($data['constants']) ? [] : $data['constants'];
        return new ConcreteValueAdapter($constants);
    }

}
