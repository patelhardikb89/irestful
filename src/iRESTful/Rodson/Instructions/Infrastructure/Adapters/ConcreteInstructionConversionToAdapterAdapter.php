<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Conversions\To\Adapters\Adapters\ToAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionConversionToAdapter;
use iRESTful\Rodson\Instructions\Domain\Containers\Adapters\Adapters\ContainerAdapterAdapter;

final class ConcreteInstructionConversionToAdapterAdapter implements ToAdapterAdapter {
    private $containerAdapterAdapter;
    public function __construct(ContainerAdapterAdapter $containerAdapterAdapter) {
        $this->containerAdapterAdapter = $containerAdapterAdapter;
    }

    public function fromDataToToAdapter(array $data) {
        $containerAdapter = $this->containerAdapterAdapter->fromDataToContainerAdapter($data);
        return new ConcreteInstructionConversionToAdapter($containerAdapter);
    }

}
