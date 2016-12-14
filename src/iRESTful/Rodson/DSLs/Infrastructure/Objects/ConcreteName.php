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

        $matches = [];
        preg_match_all('/[a-zA-Z]+/s', $organizationName, $matches);
        if (!isset($matches[0][0]) || ($matches[0][0] != $organizationName)) {
            throw new NameException('The orgaizationName ('.$organizationName.') can only contain letters.');
        }

        $matches = [];
        preg_match_all('/[a-zA-Z]+/s', $projectName, $matches);
        if (!isset($matches[0][0]) || ($matches[0][0] != $projectName)) {
            throw new NameException('The projectName ('.$projectName.') can only contain letters.');
        }

        $this->projectName = $projectName;
        $this->organizationName = $organizationName;
    }

    public function getName(): string {
        return $this->organizationName.'/'.$this->projectName;
    }

    public function getNameInParts() {
        return [
            $this->organizationName,
            $this->projectName
        ];
    }

    public function getProjectName(): string {
        return $this->projectName;
    }

    public function getOrganizationName(): string {
        return $this->organizationName;
    }

}
