<?php
namespace iRESTful\Rodson\Applications\Infrastructure\Objects;
use iRESTful\Rodson\Applications\Domain\Domains\Domain;

final class ConcreteDomain implements Domain {
    private $objects;
    private $entities;
    private $values;
    public function __construct(array $objects = null, array $entities = null, array $values = null) {

        if (empty($objects)) {
            $objects = [];
        }

        if (empty($entities)) {
            $entities = [];
        }

        if (empty($values)) {
            $values = [];
        }

        $this->objects = $objects;
        $this->entities = $entities;
        $this->values = $values;
    }

    public function getObjects() {
        return $this->objects;
    }

    public function getEntities() {
        return $this->entities;
    }
    
    public function getValues() {
        return $this->values;
    }

}
