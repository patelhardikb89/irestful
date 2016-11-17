<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Databases\Relationals\Adapters;

interface RelationalDatabaseAdapter {
    public function fromDataToRelationalDatabase(array $data);
}
