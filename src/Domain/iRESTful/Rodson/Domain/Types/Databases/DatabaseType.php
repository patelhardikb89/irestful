<?php
namespace iRESTful\Rodson\Domain\Types\Databases;

interface DatabaseType {
    public function getName();
    public function getType();
}
