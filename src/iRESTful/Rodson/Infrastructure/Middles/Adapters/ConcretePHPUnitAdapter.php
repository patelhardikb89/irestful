<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\PHPUnits\Adapters\PHPUnitAdapter;
use iRESTful\Rodson\Domain\Inputs\Rodson;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcretePHPUnit;

final class ConcretePHPUnitAdapter implements PHPUnitAdapter {

    public function __construct() {

    }

    public function fromRodsonToPHPUnit(Rodson $rodson) {
        $name = $rodson->getName();
        $projectName = $name->getProjectName();
        $organizationName = $name->getOrganizationName();
        return new ConcretePHPUnit($organizationName, $projectName);
    }

}
