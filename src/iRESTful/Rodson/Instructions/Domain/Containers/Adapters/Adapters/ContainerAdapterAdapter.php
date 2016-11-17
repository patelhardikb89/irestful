<?php
namespace iRESTful\Rodson\Instructions\Domain\Containers\Adapters\Adapters;

interface ContainerAdapterAdapter {
    public function fromDataToContainerAdapter(array $data);
}
