<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Conversions\From\Adapters\Adapters\FromAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Adapters\ConcreteInstructionConversionFromAdapter;
use iRESTful\Rodson\Instructions\Domain\Conversions\From\Exceptions\FromException;
use iRESTful\Rodson\Instructions\Domain\Containers\Adapters\Adapters\ContainerAdapterAdapter;

final class ConcreteInstructionConversionFromAdapterAdapter implements FromAdapterAdapter {
    private $containerAdapterAdapter;
    public function __construct(ContainerAdapterAdapter $containerAdapterAdapter) {
        $this->containerAdapterAdapter = $containerAdapterAdapter;
    }

    public function fromDataToFromAdapter(array $data) {

        if (!isset($data['input'])) {
            throw new FromException('The input keyname is mandatory in order to convert data to a FromAdapter object.');
        }

        $assignments = [];
        if (isset($data['assignments'])) {
            $assignments = $data['assignments'];
        }

        $containerAdapter = $this->containerAdapterAdapter->fromDataToContainerAdapter($data);
        return new ConcreteInstructionConversionFromAdapter($data['input'], $assignments, $containerAdapter);

    }

}
