<?php
namespace iRESTful\Rodson\ConfigurationsComposers\Infrastructure\Objects;
use iRESTful\Rodson\ConfigurationsComposers\Domain\Composer;
use iRESTful\Rodson\DSLs\Domain\URLs\Url;
use iRESTful\Rodson\DSLs\Domain\Authors\Author;
use iRESTful\Rodson\ConfigurationsComposers\Domain\Exceptions\ComposerException;
use iRESTful\Rodson\ClassesInstallations\Domain\Installation;

final class ConcreteComposer implements Composer {
    private $name;
    private $type;
    private $homepage;
    private $license;
    private $authors;
    private $baseNamespace;
    private $baseFolder;
    private $installation;
    public function __construct($name, $type, Url $homepage, $license, array $authors, $baseNamespace, $baseFolder, Installation $installation = null) {

        foreach($authors as $oneAuthor) {
            if (!($oneAuthor instanceof Author)) {
                throw new ComposerException('The authors array must only contain Author objects.');
            }
        }

        $this->name = $name;
        $this->type = $type;
        $this->homepage = $homepage;
        $this->license = $license;
        $this->authors = $authors;
        $this->baseNamespace = $baseNamespace;
        $this->baseFolder = $baseFolder;
        $this->installation = $installation;
    }

    public function getName() {
        return $this->name;
    }

    public function getType() {
        return $this->type;
    }

    public function getHomepage() {
        return $this->homepage;
    }

    public function getLicense() {
        return $this->license;
    }

    public function getAuthors() {
        return $this->authors;
    }

    public function getBaseNamespace() {
        return $this->baseNamespace;
    }

    public function getBaseFolder() {
        return $this->baseNamespace;
    }

    public function hasInstallation() {
        return !empty($this->installation);
    }

    public function getInstallation() {
        return $this->installation;
    }

}
