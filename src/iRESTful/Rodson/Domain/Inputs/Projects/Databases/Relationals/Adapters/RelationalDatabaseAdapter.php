<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Databases\Relationals\Adapters;

interface RelationalDatabaseAdapter {
    public function fromDataToRelationalDatabase(array $data);
}
