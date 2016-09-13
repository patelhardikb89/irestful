<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\VagrantFiles\VagrantFile;

final class ConcreteVagrantFile implements VagrantFile {
    private $name;
    private $hasRelationalDatabase;
    public function __construct($name, $hasRelationalDatabase) {
        $this->name = $name;
        $this->hasRelationalDatabase = $hasRelationalDatabase;
    }

    public function getName() {
        return $this->name;
    }

    public function hasRelationalDatabase() {
        return $this->hasRelationalDatabase;
    }

    public function getData() {
        return [
            'name' => $this->name,
            'has_relational_database' => $this->hasRelationalDatabase
        ];
    }

}
