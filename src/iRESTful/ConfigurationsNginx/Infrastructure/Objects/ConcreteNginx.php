<?php
namespace iRESTful\ConfigurationsNginx\Infrastructure\Objects;
use iRESTful\ConfigurationsNginx\Domain\Nginx;
use iRESTful\ConfigurationsNginx\Domain\Roots\Root;

final class ConcreteNginx implements Nginx {
    private $name;
    private $serverName;
    private $root;
    public function __construct($name, $serverName, Root $root) {
        $this->name = $name;
        $this->serverName = $serverName;
        $this->root = $root;
    }

    public function getName() {
        return $this->name;
    }

    public function getServerName() {
        return $this->serverName;
    }

    public function getRoot() {
        return $this->root;
    }

}
