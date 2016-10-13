<?php
namespace iRESTful\Instructions\Domain\Containers\Adapters;

interface ContainerAdapter {
    public function fromStringToContainer($string);
}
