<?php
namespace iRESTful\Rodson\Domain\Middles\Configurations;

interface Configuration {
    public function getNamespace();
    public function getObjectConfiguration();
    public function getDatabases();
    public function getControllerNode();
    public function getData();
}
