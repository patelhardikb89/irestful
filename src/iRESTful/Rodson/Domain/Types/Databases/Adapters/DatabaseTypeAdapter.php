<?php
namespace iRESTful\Rodson\Domain\Types\Databases\Adapters;

interface DatabaseTypeAdapter {
    public function fromDataToDatabaseType(array $data);
}
