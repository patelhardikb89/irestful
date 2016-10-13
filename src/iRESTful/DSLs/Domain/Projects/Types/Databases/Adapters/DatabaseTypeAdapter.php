<?php
namespace iRESTful\DSLs\Domain\Projects\Types\Databases\Adapters;

interface DatabaseTypeAdapter {
    public function fromDataToDatabaseType(array $data);
}
