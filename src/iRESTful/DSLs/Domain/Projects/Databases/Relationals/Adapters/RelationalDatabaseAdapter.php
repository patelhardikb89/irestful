<?php
namespace iRESTful\DSLs\Domain\Projects\Databases\Relationals\Adapters;

interface RelationalDatabaseAdapter {
    public function fromDataToRelationalDatabase(array $data);
}
