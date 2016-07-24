<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Rodson;
use iRESTful\Rodson\Domain\Inputs\Exceptions\RodsonException;

final class ConcreteRodson implements Rodson {
    private $name;
    private $parents;
    private $objects;
    private $controllers;
    public function __construct($name, array $objects, array $controllers, array $parents = null) {

        $verify = function(array $data = null, $type, $badTypeMessage) {

            if (empty($data)) {
                return;
            }

            $data = array_values($data);
            foreach($data as $oneElement) {

                if (!($oneElement instanceof $type)) {
                    throw new RodsonException($badTypeMessage);
                }

            }

            return $data;

        };

        if (empty($parents)) {
            $parents = null;
        }

        if (empty($name) || !is_string($name)) {
            throw new RodsonException('The name must be a non-empty string.');
        }

        if (empty($objects)) {
            throw new RodsonException('There must be at least 1 object.');
        }

        if (empty($controllers)) {
            throw new RodsonException('There must be at least 1 controller.');
        }

        $parents = $verify($parents, 'iRESTful\Rodson\Domain\Inputs\Rodson', 'The parents must only contain Rodson objects.');
        $objects = $verify($objects, 'iRESTful\Rodson\Domain\Inputs\Objects\Object', 'The objects must only contain Entity objects.');
        $controllers = $verify($controllers, 'iRESTful\Rodson\Domain\Inputs\Controllers\Controller', 'The controllers must only contain Controller objects.');

        $this->name = $name;
        $this->parents = $parents;
        $this->objects = $objects;
        $this->controllers = $controllers;
    }

    public function getName() {
        return $this->name;
    }

    public function getObjects() {
        return $this->objects;
    }

    public function getControllers() {
        return $this->controllers;
    }

    public function hasParents() {
        return !empty($this->parents);
    }

    public function getParents() {
        return $this->parents;
    }

}
