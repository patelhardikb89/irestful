<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\To\Adapters\Adapters\ToAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInstructionConversionToAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Adapters\Adapters\ContainerAdapterAdapter;

final class ConcreteClassInstructionConversionToAdapterAdapter implements ToAdapterAdapter {
    private $containerAdapterAdapter;
    public function __construct(ContainerAdapterAdapter $containerAdapterAdapter) {
        $this->containerAdapterAdapter = $containerAdapterAdapter;
    }

    public function fromDataToToAdapter(array $data) {
        $containerAdapter = $this->containerAdapterAdapter->fromDataToContainerAdapter($data);
        return new ConcreteClassInstructionConversionToAdapter($containerAdapter);
    }

}
