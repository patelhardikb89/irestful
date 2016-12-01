<?php
namespace iRESTful\Rodson\ConfigurationsComposers\Infrastructure\Adapters;
use iRESTful\Rodson\ConfigurationsComposers\Domain\Adapters\ComposerAdapter;
use iRESTful\Rodson\ConfigurationsComposers\Infrastructure\Objects\ConcreteComposer;
use iRESTful\Rodson\ConfigurationsComposers\Domain\Exceptions\ComposerException;

final class ConcreteComposerAdapter implements ComposerAdapter {
    private $baseFolder;
    public function __construct($baseFolder) {
        $this->baseFolder = $baseFolder;
    }

    public function fromDataToComposer(array $data) {

        if (!isset($data['dsl'])) {
            throw new ComposerException('The dsl keyname is mandatory in order to convert data to a Composer object.');
        }

        $installation = null;
        if (isset($data['installation'])) {
            $installation = $data['installation'];
        }

        $dslName = $data['dsl']->getName();

        $name = $dslName->getName();
        $type = $data['dsl']->getType();
        $homepage = $data['dsl']->getUrl();
        $license = $data['dsl']->getLicense();
        $authors = $data['dsl']->getAuthors();
        $baseNamespace = $dslName->getOrganizationName();

        return new ConcreteComposer($name, $type, $homepage, $license, $authors, $baseNamespace, $this->baseFolder, $installation);

    }

}
