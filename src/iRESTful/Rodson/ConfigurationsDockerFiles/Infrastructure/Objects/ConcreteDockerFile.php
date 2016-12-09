<?php
declare(strict_types=1);
namespace iRESTful\Rodson\ConfigurationsDockerFiles\Infrastructure\Objects;
use iRESTful\Rodson\ConfigurationsDockerFiles\Domain\DockerFile;
use iRESTful\Rodson\DSLs\Domain\URLs\Url;
use iRESTful\Rodson\DSLs\Domain\Authors\Author;
use iRESTful\Rodson\DSLs\Domain\Names\Name;

final class ConcreteDockerFile implements DockerFile {
    private $name;
    private $domain;
    private $maintainer;
    private $version;
    private $repositoryUrl;
    public function __construct(Name $name, Author $maintainer, string $version, URL $repositoryUrl) {
        $this->name = $name;
        $this->domain = $name->getName();
        $this->maintainer = $maintainer;
        $this->version = $version;
        $this->repositoryUrl = $repositoryUrl;
    }

    public function getName(): Name {
        return $this->name;
    }

    public function getDomain(): string {
        return $this->domain;
    }

    public function getMaintainer(): Author {
        return $this->maintainer;
    }

    public function getVersion(): string {
        return $this->version;
    }

    public function getRepositoryUrl(): URL {
        return $this->repositoryUrl;
    }

}
