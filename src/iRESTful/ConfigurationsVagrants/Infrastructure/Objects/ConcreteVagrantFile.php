<?php
namespace iRESTful\ConfigurationsVagrants\Infrastructure\Objects;
use iRESTful\ConfigurationsVagrants\Domain\VagrantFile;
use iRESTful\ConfigurationsNginx\Domain\Nginx;

final class ConcreteVagrantFile implements VagrantFile {
    private $name;
    private $databaseName;
    private $nginx;
    private $hasRelationalDatabase;
    public function __construct($name, $databaseName, Nginx $nginx, $hasRelationalDatabase) {
        $this->name = $name;
        $this->databaseName = $databaseName;
        $this->nginx = $nginx;
        $this->hasRelationalDatabase = $hasRelationalDatabase;
    }

    public function getName() {
        return $this->name;
    }

    public function getDatabaseName() {
        return $this->databaseName;
    }

    public function getNginx() {
        return $this->nginx;
    }

    public function hasRelationalDatabase() {
        return $this->hasRelationalDatabase;
    }

}
