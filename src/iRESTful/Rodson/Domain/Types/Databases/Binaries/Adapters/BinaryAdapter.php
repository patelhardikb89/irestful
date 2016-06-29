<?php
namespace iRESTful\Rodson\Domain\Types\Databases\Binaries\Adapters;

interface BinaryAdapter {
    public function fromDataToBinary(array $data);
}
