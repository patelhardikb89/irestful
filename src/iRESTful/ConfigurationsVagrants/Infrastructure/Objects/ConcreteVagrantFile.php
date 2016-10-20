<?php
namespace iRESTful\ConfigurationsVagrants\Infrastructure\Objects;
use iRESTful\ConfigurationsVagrants\Domain\VagrantFile;
use iRESTful\ConfigurationsNginx\Domain\Nginx;

final class ConcreteVagrantFile implements VagrantFile {
    private $name;
    private $nginx;
    private $hasRelationalDatabase;
    public function __construct($name, Nginx $nginx, $hasRelationalDatabase) {
        $this->name = $name;
        $this->nginx = $nginx;
        $this->hasRelationalDatabase = $hasRelationalDatabase;
    }

    public function getName() {
        return $this->name;
    }

    public function getNginx() {
        return $this->nginx;
    }

    public function hasRelationalDatabase() {
        return $this->hasRelationalDatabase;
    }

}
