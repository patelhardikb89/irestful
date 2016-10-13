<?php
namespace iRESTful\ConfigurationsComposers\Infrastructure\Adapters;
use iRESTful\ConfigurationsComposers\Domain\Adapters\ComposerAdapter;
use iRESTful\ConfigurationsComposers\Infrastructure\Objects\ConcreteComposer;
use iRESTful\ConfigurationsComposers\Domain\Exceptions\ComposerException;

final class ConcreteComposerAdapter implements ComposerAdapter {
    private $baseFolder;
    public function __construct($baseFolder) {
        $this->baseFolder = $baseFolder;
    }

    public function fromDataToComposer(array $data) {

        if (!isset($data['dsl'])) {
            throw new ComposerException('The dsl keyname is mandatory in order to convert data to a Composer object.');
        }

        if (!isset($data['installation'])) {
            throw new ComposerException('The installation keyname is mandatory in order to convert data to a Composer object.');
        }

        $dslName = $data['dsl']->getName();

        $name = $dslName->getName();
        $type = $data['dsl']->getType();
        $homepage = $data['dsl']->getUrl();
        $license = $data['dsl']->getLicense();
        $authors = $data['dsl']->getAuthors();
        $baseNamespace = $dslName->getOrganizationName();

        return new ConcreteComposer($name, $type, $homepage, $license, $authors, $baseNamespace, $this->baseFolder, $data['installation']);

    }

}
