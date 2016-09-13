<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Adapters\Adapters\ContainerAdapterAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionContainerAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Exceptions\ContainerException;
use iRESTful\Rodson\Domain\Inputs\Projects\Values\Adapters\Adapters\ValueAdapterAdapter;

final class ConcreteClassInstructionContainerAdapterAdapter implements ContainerAdapterAdapter {
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

        return new ConcreteClassInstructionContainerAdapter($valueAdapter, $data['annotated_entities']);

    }

}
