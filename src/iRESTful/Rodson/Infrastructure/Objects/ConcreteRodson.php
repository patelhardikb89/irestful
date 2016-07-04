<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Rodson;
use iRESTful\Rodson\Domain\Exceptions\RodsonException;

final class ConcreteRodson implements Rodson {
    private $name;
    private $parents;
    private $objects;
    private $controllers;
    public function __construct($name, array $objects, array $controllers, array $parents = null) {

        $verify = function(array $data = null, $type, $badIndexMessage, $badTypeMessage) {

            if (empty($data)) {
                return;
            }

            foreach($data as $index => $oneElement) {

                if (!is_integer($index)) {
                    throw new RodsonException($badIndexMessage);
                }

                if (!($oneElement instanceof $type)) {
                    throw new RodsonException($badTypeMessage);
                }

            }

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

        $verify($parents, 'iRESTful\Rodson\Domain\Rodson', 'The indexes in the parents array must be integers.', 'The parents must only contain Rodson objects.');
        $verify($objects, 'iRESTful\Rodson\Domain\Objects\Object', 'The indexes in the objects array must be integers.', 'The objects must only contain Entity objects.');
        $verify($controllers, 'iRESTful\Rodson\Domain\Controllers\Controller', 'The indexes in the controllers array must be integers.', 'The controllers must only contain Controller objects.');

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
