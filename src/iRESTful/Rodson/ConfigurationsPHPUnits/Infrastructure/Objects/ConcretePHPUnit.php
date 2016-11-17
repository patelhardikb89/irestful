<?php
namespace iRESTful\Rodson\ConfigurationsPHPUnits\Infrastructure\Objects;
use iRESTful\Rodson\ConfigurationsPHPUnits\Domain\PHPUnit;

final class ConcretePHPUnit implements PHPUnit {
    private $organizationName;
    private $projectName;
    public function __construct($organizationName, $projectName) {
        $this->organizationName = $organizationName;
        $this->projectName = $projectName;
    }

    public function getOrganizationName() {
        return $this->organizationName;
    }

    public function getProjectName() {
        return $this->projectName;
    }

}
