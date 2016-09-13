<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Composers\Composer;
use iRESTful\Rodson\Domain\Inputs\URLs\Url;
use iRESTful\Rodson\Domain\Inputs\Authors\Author;
use iRESTful\Rodson\Domain\Middles\Composers\Exceptions\ComposerException;

final class ConcreteComposer implements Composer {
    private $name;
    private $type;
    private $homepage;
    private $license;
    private $authors;
    private $baseNamespace;
    private $baseFolder;
    public function __construct($name, $type, Url $homepage, $license, array $authors, $baseNamespace, $baseFolder) {

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

    public function getData() {

        $authors = $this->getAuthors();
        array_walk($authors, function(&$element, $index) {
            $element = $element->getData();
        });

        return [
            'name' => $this->name,
            'type' => $this->type,
            'homepage' => $this->homepage->get(),
            'license' => $this->license,
            'authors' => $authors,
            'base_namespace' => $this->baseNamespace,
            'base_folder' => $this->baseFolder
        ];
    }

}
