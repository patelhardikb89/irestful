<?php
namespace iRESTful\Instructions\Domain\Containers\Adapters\Adapters;

interface ContainerAdapterAdapter {
    public function fromDataToContainerAdapter(array $data);
}
