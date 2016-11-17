<?php
namespace iRESTful\Rodson\ClassesTests\Infrastructure\Objects;
use iRESTful\Rodson\ClassesTests\Domain\CRUDs\CRUD;
use iRESTful\Rodson\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\Rodson\Classes\Domain\Samples\Sample;
use iRESTful\Rodson\ClassesInstallations\Domain\Installation;

final class ConcreteTestCRUD implements CRUD {
    private $namespace;
    private $samples;
    private $installation;
    public function __construct(ClassNamespace $namespace, array $samples, Installation $installation) {
        $this->namespace = $namespace;
        $this->samples = $samples;
        $this->installation = $installation;
    }

    public function getNamespace() {
        return $this->namespace;
    }

    public function getSamples() {
        return $this->samples;
    }

    public function getInstallation() {
        return $this->installation;
    }

}
