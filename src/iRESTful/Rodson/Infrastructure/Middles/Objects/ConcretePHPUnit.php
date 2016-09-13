<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\PHPUnits\PHPUnit;

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

    public function getData() {
        return [
            'organization_name' => $this->organizationName,
            'project_name' => $this->projectName
        ];
    }

}
