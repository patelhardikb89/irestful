<?php
namespace iRESTful\Rodson\Instructions\Domain\Containers\Adapters;

interface ContainerAdapter {
    public function fromStringToContainer($string);
}
