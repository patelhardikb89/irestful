<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Adapters\Adapters;

interface DatabaseAdapterAdapter {
    public function fromDataToDatabaseAdapter(array $data);
}
