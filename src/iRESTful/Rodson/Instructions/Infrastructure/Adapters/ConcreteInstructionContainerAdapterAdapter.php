<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Containers\Adapters\Adapters\ContainerAdapterAdapter;
use iRESTful\Rodson\Instructions\Domain\Values\Adapters\Adapters\ValueAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionContainerAdapter;
use iRESTful\Rodson\Instructions\Domain\Containers\Exceptions\ContainerException;

final class ConcreteInstructionContainerAdapterAdapter implements ContainerAdapterAdapter {
    private $valueAdapterAdapter;
    public function __construct(ValueAdapterAdapter $valueAdapterAdapter) {
        $this->valueAdapterAdapter = $valueAdapterAdapter;
    }

    public function fromDataToContainerAdapter(array $data) {

        if (!isset($data['annotated_entities'])) {
            throw new ContainerException('The annotated_entities keyname is mandatory in order to convert data to a ContainerAdapter.');
        }

        $constants = empty($data['constants']) ? [] : $data['constants'];
        $valueAdapter = $this->valueAdapterAdapter->fromDataToValueAdapter([
            'constants' => $constants
        ]);

        return new ConcreteInstructionContainerAdapter($valueAdapter, $data['annotated_entities']);

    }

}
