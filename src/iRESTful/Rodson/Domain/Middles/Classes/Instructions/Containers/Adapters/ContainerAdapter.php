<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Adapters;

interface ContainerAdapter {
    public function fromStringToContainer($string);
}
