<?php
namespace iRESTful\DSLs\Domain\Projects\Databases\Adapters;

interface DatabaseAdapter {
    public function fromDataToDatabases(array $data);
    public function fromDataToDatabase(array $data);
}
