<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Names\Name;

final class ConcreteName implements Name {
    private $projectName;
    private $organizationName;
    public function __construct($projectName, $organizationName) {
        $this->projectName = $projectName;
        $this->organizationName = $organizationName;
    }

    public function getName() {
        return $this->organizationName.'/'.$this->projectName;
    }

    public function getProjectName() {
        return $this->projectName;
    }

    public function getOrganizationName() {
        return $this->organizationName;
    }

}
