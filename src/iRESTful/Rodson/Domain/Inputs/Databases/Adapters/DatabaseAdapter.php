<?php
namespace iRESTful\Rodson\Domain\Inputs\Databases\Adapters;

interface DatabaseAdapter {
    public function fromDataToDatabases(array $data);
    public function fromDataToDatabase(array $data);
}
