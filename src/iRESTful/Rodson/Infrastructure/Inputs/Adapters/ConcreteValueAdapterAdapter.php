<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Values\Adapters\Adapters\ValueAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteValueAdapter;
use iRESTful\Rodson\Domain\Inputs\Values\Exceptions\ValueException;

final class ConcreteValueAdapterAdapter implements ValueAdapterAdapter {

    public function __construct() {

    }

    public function fromDataToValueAdapter(array $data) {

        if (!isset($data['constants'])) {
            throw new ValueException('The constants keyname is mandatory in order to convert data to a ValueAdapter object.');
        }

        return new ConcreteValueAdapter($data['constants']);
    }

}
