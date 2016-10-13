<?php
namespace iRESTful\ConfigurationsVagrants\Infrastructure\Objects;
use iRESTful\ConfigurationsVagrants\Domain\VagrantFile;

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

}
