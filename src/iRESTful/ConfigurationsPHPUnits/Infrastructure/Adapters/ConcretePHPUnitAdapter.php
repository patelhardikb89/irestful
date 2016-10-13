<?php
namespace iRESTful\ConfigurationsPHPUnits\Infrastructure\Adapters;
use iRESTful\ConfigurationsPHPUnits\Domain\Adapters\PHPUnitAdapter;
use iRESTful\DSLs\Domain\DSL;
use iRESTful\ConfigurationsPHPUnits\Infrastructure\Objects\ConcretePHPUnit;

final class ConcretePHPUnitAdapter implements PHPUnitAdapter {

    public function __construct() {

    }

    public function fromDSLToPHPUnit(DSL $dsl) {
        $name = $dsl->getName();
        $projectName = $name->getProjectName();
        $organizationName = $name->getOrganizationName();
        return new ConcretePHPUnit($organizationName, $projectName);
    }

}
