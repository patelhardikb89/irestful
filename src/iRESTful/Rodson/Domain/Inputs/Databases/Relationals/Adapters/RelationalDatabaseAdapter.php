<?php
namespace iRESTful\Rodson\Domain\Inputs\Databases\Relationals\Adapters;

interface RelationalDatabaseAdapter {
    public function fromDataToRelationalDatabase(array $data);
}
