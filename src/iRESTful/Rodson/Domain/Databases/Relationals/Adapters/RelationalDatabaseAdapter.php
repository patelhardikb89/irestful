<?php
namespace iRESTful\Rodson\Domain\Databases\Relationals\Adapters;

interface RelationalDatabaseAdapter {
    public function fromDataToRelationalDatabase(array $data);
}
