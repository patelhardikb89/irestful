<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\DSL;
use iRESTful\Rodson\DSLs\Domain\URLs\Url;
use iRESTful\Rodson\DSLs\Domain\Projects\Project;
use iRESTful\Rodson\DSLs\Domain\Exceptions\DSLException;
use iRESTful\Rodson\DSLs\Domain\Authors\Author;
use iRESTful\Rodson\DSLs\Domain\Names\Name;

final class ConcreteDSL implements DSL {
    private $name;
    private $type;
    private $urls;
    private $license;
    private $authors;
    private $maintainer;
    private $project;
    private $version;
    public function __construct(Name $name, string $type, array $urls, string $license, array $authors, Author $maintainer, Project $project, string $version) {

        if (empty($authors)) {
            throw new DSLException('The authors array cannot be empty.');
        }

        if (empty($type)) {
            throw new DSLException('The type cannot be empty.');
        }

        if (empty($license)) {
            throw new DSLException('The license cannot be empty.');
        }

        if (!isset($urls['repository']) || !(($urls['repository'] instanceof Url))) {
            throw new DSLException('The urls array must contain a repository url.');
        }

        if (!isset($urls['homepage']) || !(($urls['homepage'] instanceof Url))) {
            throw new DSLException('The urls array must contain a homepage url.');
        }

        foreach($authors as $oneAuthor) {
            if (!($oneAuthor instanceof Author)) {
                throw new DSLException('The authors array must only contain Author objects.');
            }
        }

        $this->name = $name;
        $this->type = $type;
        $this->urls = $urls;
        $this->license = $license;
        $this->authors = $authors;
        $this->maintainer = $maintainer;
        $this->project = $project;
        $this->version = $version;

    }

    public function getName(): Name {
        return $this->name;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getUrls(): array {
        return $this->urls;
    }

    public function getLicense(): string {
        return $this->license;
    }

    public function getAuthors(): array {
        return $this->authors;
    }

    public function getMaintainer(): Author {
        return $this->maintainer;
    }

    public function getProject(): Project {
        return $this->project;
    }

    public function getVersion(): string {
        return $this->version;
    }

}
