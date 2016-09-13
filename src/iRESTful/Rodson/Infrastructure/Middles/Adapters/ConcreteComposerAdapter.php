<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Composers\Adapters\ComposerAdapter;
use iRESTful\Rodson\Domain\Inputs\Rodson;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteComposer;

final class ConcreteComposerAdapter implements ComposerAdapter {
    private $baseFolder;
    public function __construct($baseFolder) {
        $this->baseFolder = $baseFolder;
    }

    public function fromRodsonToComposer(Rodson $rodson) {
        $rodsonName = $rodson->getName();

        $name = $rodsonName->getName();
        $type = $rodson->getType();
        $homepage = $rodson->getUrl();
        $license = $rodson->getLicense();
        $authors = $rodson->getAuthors();
        $baseNamespace = $rodsonName->getOrganizationName();

        return new ConcreteComposer($name, $type, $homepage, $license, $authors, $baseNamespace, $this->baseFolder);

    }

}
