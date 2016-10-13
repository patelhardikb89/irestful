<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\DSL;
use iRESTful\DSLs\Domain\URLs\Url;
use iRESTful\DSLs\Domain\Projects\Project;
use iRESTful\DSLs\Domain\Exceptions\DSLException;
use iRESTful\DSLs\Domain\Authors\Author;
use iRESTful\DSLs\Domain\Names\Name;

final class ConcreteDSL implements DSL {
    private $name;
    private $type;
    private $url;
    private $license;
    private $authors;
    private $project;
    public function __construct(Name $name, string $type, Url $url, string $license, array $authors, Project $project) {

        if (empty($authors)) {
            throw new DSLException('The authors array cannot be empty.');
        }

        if (empty($type)) {
            throw new DSLException('The type cannot be empty.');
        }

        if (empty($license)) {
            throw new DSLException('The license cannot be empty.');
        }

        foreach($authors as $oneAuthor) {
            if (!($oneAuthor instanceof Author)) {
                throw new DSLException('The authors array must only contain Author objects.');
            }
        }

        $this->name = $name;
        $this->type = $type;
        $this->url = $url;
        $this->license = $license;
        $this->authors = $authors;
        $this->project = $project;

    }

    public function getName(): Name {
        return $this->name;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getUrl(): Url {
        return $this->url;
    }

    public function getLicense(): string {
        return $this->license;
    }

    public function getAuthors(): array {
        return $this->authors;
    }

    public function getProject(): Project {
        return $this->project;
    }

}
