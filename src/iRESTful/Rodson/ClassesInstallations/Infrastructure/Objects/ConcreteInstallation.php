<?php
namespace iRESTful\Rodson\ClassesInstallations\Infrastructure\Objects;
use iRESTful\Rodson\ClassesInstallations\Domain\Installation;
use iRESTful\Rodson\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\Rodson\DSLs\Domain\Projects\Databases\Relationals\RelationalDatabase;
use iRESTful\Rodson\ClassesConfigurations\Domain\Objects\ObjectConfiguration;
use iRESTful\Rodson\ClassesInstallations\Domain\Exceptions\InstallationException;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Data\EntityData;

final class ConcreteInstallation implements Installation {
    private $namespace;
    private $objectConfiguration;
    private $database;
    private $entityDatas;
    public function __construct(ClassNamespace $namespace, ObjectConfiguration $objectConfiguration, RelationalDatabase $database, array $entityDatas = null) {

        if (empty($entityDatas)) {
            $entityDatas = null;
        }

        if (!empty($entityDatas)) {
            foreach($entityDatas as $oneEntityData) {
                if (!($oneEntityData instanceof EntityData)) {
                    throw new InstallationException('The entityDatas array must only contain EntityData objects.');
                }
            }
        }

        $this->namespace = $namespace;
        $this->objectConfiguration = $objectConfiguration;
        $this->database = $database;
        $this->entityDatas = $entityDatas;
    }

    public function getNamespace() {
        return $this->namespace;
    }

    public function getObjectConfiguration() {
        return $this->objectConfiguration;
    }

    public function getRelationalDatabase() {
        return $this->database;
    }

    public function hasEntityDatas() {
        return !empty($this->entityDatas);
    }

    public function getEntityDatas() {
        return $this->entityDatas;
    }

}
