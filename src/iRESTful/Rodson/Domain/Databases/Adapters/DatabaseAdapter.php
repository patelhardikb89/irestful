<?php
namespace iRESTful\Rodson\Domain\Databases\Adapters;

interface DatabaseAdapter {
    public function fromDataToDatabases(array $data);
    public function fromDataToDatabase(array $data);
}
