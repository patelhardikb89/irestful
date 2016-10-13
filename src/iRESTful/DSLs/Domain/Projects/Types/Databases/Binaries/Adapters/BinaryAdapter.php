<?php
namespace iRESTful\DSLs\Domain\Projects\Types\Databases\Binaries\Adapters;

interface BinaryAdapter {
    public function fromDataToBinary(array $data);
}
