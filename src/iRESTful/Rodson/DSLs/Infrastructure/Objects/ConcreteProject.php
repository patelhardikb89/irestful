<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Project;
use iRESTful\Rodson\DSLs\Domain\Projects\Exceptions\ProjectException;

final class ConcreteProject implements Project {
    private $parents;
    private $objects;
    private $entities;
    private $controllers;
    public function __construct(array $objects = null, array $entities = null, array $controllers = null, array $parents = null) {

        $verify = function(array $data = null, $type, $badTypeMessage, $badKeynameMessage) {

            if (empty($data)) {
                return null;
            }

            foreach($data as $keyname => $oneElement) {

                if (!is_string($keyname)) {
                    throw new ProjectException($badKeynameMessage);
                }

                if (!($oneElement instanceof $type)) {
                    throw new ProjectException($badTypeMessage);
                }

            }

            return $data;

        };

        $parents = $verify($parents, 'iRESTful\Rodson\DSLs\Domain\SubDSLs\SubDSL', 'The parents must only contain SubDSL objects.', 'The parents array must be an array, where the keynames are strings.');
        $objects = $verify($objects, 'iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object', 'The objects must only contain Object objects.', 'The objects array must be an array, where the keynames are strings.');
        $entities = $verify($entities, 'iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Entity', 'The entities must only contain Entity objects.', 'The entities array must be an array, where the keynames are strings.');
        $controllers = $verify($controllers, 'iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Controller', 'The controllers must only contain Controller objects.', 'The controllers array must be an array, where the keynames are strings.');

        if (empty($objects) && empty($controllers)) {
            throw new ProjectException('There objects and controllers cannot be both empty.');
        }

        $this->parents = $parents;
        $this->objects = $objects;
        $this->entities = $entities;
        $this->controllers = $controllers;
    }

    public function getTypes(): array {

        $output = [];
        if (!$this->hasObjects()) {
            return $output;
        }

        foreach($this->objects as $oneObject) {
            $objectTypes = $oneObject->getTypes();
            foreach($objectTypes as $oneObjectType) {
                $name = $oneObjectType->getName();
                $output[$name] = $oneObjectType;
            }
        }

        return $output;
    }

    public function getRelationalDatabase() {

        if (!$this->hasObjects()) {
            return null;
        }

        foreach($this->objects as $oneObject) {

            if ($oneObject->hasDatabase()) {
                $database = $oneObject->getDatabase();
                if ($database->hasRelational()) {
                    return $database->getRelational();
                }
            }

        }

        return null;
    }

    public function hasObjects() {
        return !empty($this->objects);
    }

    public function getObjects() {
        return $this->objects;
    }

    public function hasEntities() {
        return !empty($this->entities);
    }

    public function getEntities() {
        return $this->entities;
    }

    public function hasEntityByName(string $name): bool {
        if (!$this->hasEntities()) {
            return false;
        }

        return isset($this->entities[$name]);
    }

    public function getEntityByName(string $name) {
        if (!$this->hasEntityByName($name)) {
            return null;
        }

        return$this->entities[$name];
    }

    public function hasControllers() {
        return !empty($this->controllers);
    }

    public function getControllers() {
        return $this->controllers;
    }

    public function hasParents(): bool {
        return !empty($this->parents);
    }

    public function getParents() {
        return $this->parents;
    }

}
