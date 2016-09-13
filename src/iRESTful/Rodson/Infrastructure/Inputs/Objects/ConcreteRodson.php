<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Rodson;
use iRESTful\Rodson\Domain\Inputs\URLs\Url;
use iRESTful\Rodson\Domain\Inputs\Projects\Project;
use iRESTful\Rodson\Domain\Inputs\Exceptions\RodsonException;
use iRESTful\Rodson\Domain\Inputs\Authors\Author;
use iRESTful\Rodson\Domain\Inputs\Names\Name;

final class ConcreteRodson implements Rodson {
    private $name;
    private $type;
    private $url;
    private $license;
    private $authors;
    private $project;
    public function __construct(Name $name, $type, Url $url, $license, array $authors, Project $project) {

        if (empty($authors)) {
            throw new RodsonException('The authors array cannot be empty.');
        }

        foreach($authors as $oneAuthor) {
            if (!($oneAuthor instanceof Author)) {
                throw new RodsonException('The authors array must only contain Author objects.');
            }
        }

        $this->name = $name;
        $this->type = $type;
        $this->url = $url;
        $this->license = $license;
        $this->authors = $authors;
        $this->project = $project;

    }

    public function getName() {
        return $this->name;
    }

    public function getType() {
        return $this->type;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getLicense() {
        return $this->license;
    }

    public function getAuthors() {
        return $this->authors;
    }

    public function getProject() {
        return $this->project;
    }

}
