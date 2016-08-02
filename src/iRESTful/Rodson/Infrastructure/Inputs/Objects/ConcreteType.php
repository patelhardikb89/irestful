<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Types\Exceptions\TypeException;
use iRESTful\Rodson\Domain\Inputs\Types\Databases\DatabaseType;
use iRESTful\Rodson\Domain\Inputs\Adapters\Adapter;
use iRESTful\Rodson\Domain\Inputs\Codes\Methods\Method;

final class ConcreteType implements Type {
    private $name;
    private $databaseType;
    private $databaseAdapter;
    private $viewAdapter;
    private $method;
    public function __construct($name, DatabaseType $databaseType, Adapter $databaseAdapter = null, Adapter $viewAdapter = null, Method $method = null) {

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

    public function hasDatabaseAdapter() {
        return !empty($this->databaseAdapter);
    }

    public function getDatabaseAdapter() {
        return $this->databaseAdapter;
    }

    public function getDatabaseAdapterMethodName() {

        if (!$this->hasDatabaseAdapter()) {
            return null;
        }

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

    private function getMethodName(Adapter $adapter) {
        $fromName = $this->getName();
        if ($adapter->hasFromType()) {
            $fromName = $adapter->fromType()->getName();
        }

        $toName = $this->getName();
        if ($adapter->hasToType()) {
            $toName = $adapter->toType()->getName();
        }

        return 'from'.ucfirst($fromName).'To'.ucfirst($toName);
    }

}
