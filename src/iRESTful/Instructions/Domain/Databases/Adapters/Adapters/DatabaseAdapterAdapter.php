<?php
namespace iRESTful\Instructions\Domain\Databases\Adapters\Adapters;

interface DatabaseAdapterAdapter {
    public function fromDataToDatabaseAdapter(array $data);
}
