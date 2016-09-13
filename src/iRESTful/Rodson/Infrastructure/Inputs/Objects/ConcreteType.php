<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Exceptions\TypeException;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\DatabaseType;
use iRESTful\Rodson\Domain\Inputs\Projects\Converters\Converter;
use iRESTful\Rodson\Domain\Inputs\Projects\Codes\Methods\Method;
use iRESTful\Rodson\Domain\Inputs\Projects\Converters\Types\Type as ConverterType;

final class ConcreteType implements Type {
    private $name;
    private $databaseType;
    private $databaseAdapter;
    private $viewAdapter;
    private $method;
    public function __construct($name, DatabaseType $databaseType, Converter $databaseAdapter, Converter $viewAdapter = null, Method $method = null) {

        if (empty($name) || !is_string($name)) {
            throw new TypeException('The name must be a non-empty string.');
        }

        $this->name = $name;
        $this->databaseType = $databaseType;
        $this->databaseAdapter = $databaseAdapter;
        $this->viewAdapter = $viewAdapter;
        $this->method = $method;
    }

    public function getName() {
        return $this->name;
    }

    public function getDatabaseType() {
        return $this->databaseType;
    }

    public function getDatabaseAdapter() {
        return $this->databaseAdapter;
    }

    public function getDatabaseAdapterMethodName() {
        return $this->getMethodName($this->databaseAdapter);
    }

    public function hasViewAdapter() {
        return !empty($this->viewAdapter);
    }

    public function getViewAdapter() {
        return $this->viewAdapter;
    }

    public function getViewAdapterMethodName() {

        if (!$this->hasViewAdapter()) {
            return null;
        }

        return $this->getMethodName($this->viewAdapter);

    }

    public function hasMethod() {
        return !empty($this->method);
    }

    public function getMethod() {
        return $this->method;
    }

    private function getMethodName(Converter $converter) {

        $getConverterTypeName = function(ConverterType $type) {
            if ($type->hasType()) {
                return $type->getType()->getName();
            }

            return $type->getPrimitive()->getName();
        };

        $fromName = $this->getName();
        if ($converter->hasFromType()) {
            $fromType = $converter->fromType();
            $fromName = $getConverterTypeName($fromType);
        }

        $toName = $this->getName();
        if ($converter->hasToType()) {
            $toType = $converter->toType();
            $toName = $getConverterTypeName($toType);
        }

        return 'from'.ucfirst($fromName).'To'.ucfirst($toName);
    }

}
