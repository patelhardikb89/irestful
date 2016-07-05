<?php
namespace iRESTful\Rodson\Domain\Inputs\Types\Databases\Adapters;

interface DatabaseTypeAdapter {
    public function fromDataToDatabaseType(array $data);
}
