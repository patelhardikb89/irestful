<?php
namespace iRESTful\ClassesTests\Infrastructure\Objects;
use iRESTful\ClassesTests\Domain\CRUDs\CRUD;
use iRESTful\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\Classes\Domain\Samples\Sample;
use iRESTful\ClassesInstallations\Domain\Installation;

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
