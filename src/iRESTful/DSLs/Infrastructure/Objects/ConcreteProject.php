<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Projects\Project;
use iRESTful\DSLs\Domain\Projects\Exceptions\ProjectException;

final class ConcreteProject implements Project {
    private $parents;
    private $objects;
    private $controllers;
    public function __construct(array $objects, array $controllers, array $parents = null) {

        $verify = function(array $data = null, $type, $badTypeMessage) {

            if (empty($data)) {
                return;
            }

            $data = array_values($data);
            foreach($data as $oneElement) {

                if (!($oneElement instanceof $type)) {
                    throw new ProjectException($badTypeMessage);
                }

            }

            return $data;

        };

        if (empty($parents)) {
            $parents = null;
        }

        if (empty($objects)) {
            throw new ProjectException('There must be at least 1 object.');
        }

        if (empty($controllers)) {
            throw new ProjectException('There must be at least 1 controller.');
        }

        $parents = $verify($parents, 'iRESTful\DSLs\Domain\DSL', 'The parents must only contain DSL objects.');
        $objects = $verify($objects, 'iRESTful\DSLs\Domain\Projects\Objects\Object', 'The objects must only contain Entity objects.');
        $controllers = $verify($controllers, 'iRESTful\DSLs\Domain\Projects\Controllers\Controller', 'The controllers must only contain Controller objects.');

        $this->parents = $parents;
        $this->objects = $objects;
        $this->controllers = $controllers;
    }

    public function getObjects(): array {
        return $this->objects;
    }

    public function getControllers(): array {
        return $this->controllers;
    }

    public function getTypes(): array {
        $output = [];
        foreach($this->objects as $oneObject) {
            $objectTypes = $oneObject->getTypes();
            foreach($objectTypes as $oneObjectType) {
                $name = $oneObjectType->getName();
                $output[$name] = $oneObjectType;
            }
        }

        return array_values($output);
    }

    public function getRelationalDatabase() {
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

    public function hasParents(): bool {
        return !empty($this->parents);
    }

    public function getParents() {
        return $this->parents;
    }

}
