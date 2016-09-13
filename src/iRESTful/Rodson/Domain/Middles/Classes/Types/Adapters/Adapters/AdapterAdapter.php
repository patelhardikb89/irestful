<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Adapters\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;

interface AdapterAdapter {
    public function fromTypeToAdapter(Type $type);
}
