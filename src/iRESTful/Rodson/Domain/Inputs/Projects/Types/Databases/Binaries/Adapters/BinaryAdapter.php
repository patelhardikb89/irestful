<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Binaries\Adapters;

interface BinaryAdapter {
    public function fromDataToBinary(array $data);
}
