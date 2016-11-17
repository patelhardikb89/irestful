<?php
namespace iRESTful\Rodson\ConfigurationsPHPUnits\Infrastructure\Adapters;
use iRESTful\Rodson\ConfigurationsPHPUnits\Domain\Adapters\PHPUnitAdapter;
use iRESTful\Rodson\DSLs\Domain\DSL;
use iRESTful\Rodson\ConfigurationsPHPUnits\Infrastructure\Objects\ConcretePHPUnit;

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
