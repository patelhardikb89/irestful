<?php
namespace iRESTful\Rodson\Domain\Inputs\Types\Databases\Binaries\Adapters;

interface BinaryAdapter {
    public function fromDataToBinary(array $data);
}
