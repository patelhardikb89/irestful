<?php
namespace iRESTful\Rodson\DSLs\Domain\Repositories;

interface DSLRepository {
    public function retrieve(string $jsonFilePath);
}
