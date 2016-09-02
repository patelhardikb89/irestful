<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Adapters\Adapters;

interface ContainerAdapterAdapter {
    public function fromDataToContainerAdapter(array $data);
}
