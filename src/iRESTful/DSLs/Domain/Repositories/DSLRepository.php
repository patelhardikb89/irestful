<?php
namespace iRESTful\DSLs\Domain\Repositories;

interface DSLRepository {
    public function retrieve(string $jsonFilePath);
}
