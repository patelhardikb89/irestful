<?php
namespace iRESTful\Rodson\Instructions\Domain\Databases\Adapters\Adapters;

interface DatabaseAdapterAdapter {
    public function fromDataToDatabaseAdapter(array $data);
}
