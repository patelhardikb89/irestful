<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Interface;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Method;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Exceptions\InterfaceException;

final class ConcreteInterface implements Interface {
    private $name;
    private $methods;
    private $subInterfaces;
    private $attachedInterfaces;
    public function __construct($name, array $methods, array $subInterfaces, array $attachedInterfaces = null) {

        if (empty($attachedInterfaces)) {
            $attachedInterfaces = null;
        }

        if (empty($name) || !is_string($name)) {
            throw new InterfaceException('The name must be a non-empty string.');
        }

        foreach($methods as $oneMethod) {

            if (!($oneMethod instanceof Method)) {
                throw new InterfaceException('The methods array must only contain Method objects.');
            }

        }

        foreach($subInterfaces as $oneSubInterface) {

            if (!($oneSubInterface instanceof Interface)) {
                throw new InterfaceException('The subInterfaces array must only contain Interface objects.');
            }

        }

        $this->name = $name;
        $this->methods = $methods;
        $this->subInterfaces = $subInterfaces;
        $this->attachedInterfaces = $attachedInterfaces;

    }

    public function getName() {
        return $this->name;
    }

    public function getMethods() {
        return $this->methods;
    }

    public function hasSubInterfaces() {
        return !empty($this->subInterfaces);
    }

    public function getSubInterfaces() {
        return $this->subInterfaces;
    }

    public function hasAttachedInterfaces() {
        return !empty($this->attachedInterfaces);
    }

    public function getAttachedInterfaces() {
        return $this->attachedInterfaces;
    }
}
