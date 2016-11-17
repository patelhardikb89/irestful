<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Names\Name;
use iRESTful\Rodson\DSLs\Domain\Names\Exceptions\NameException;

final class ConcreteName implements Name {
    private $projectName;
    private $organizationName;
    public function __construct(string $projectName, string $organizationName) {

        if (empty($projectName)) {
            throw new NameException('The projectName must be a non-empty string.');
        }

        if (empty($organizationName)) {
            throw new NameException('The organizationName must be a non-empty string.');
        }

        $this->projectName = $projectName;
        $this->organizationName = $organizationName;
    }

    public function getName(): string {
        return $this->organizationName.'/'.$this->projectName;
    }

    public function getProjectName(): string {
        return $this->projectName;
    }

    public function getOrganizationName(): string {
        return $this->organizationName;
    }

}
