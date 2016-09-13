<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Adapters;

interface DatabaseTypeAdapter {
    public function fromDataToDatabaseType(array $data);
}
