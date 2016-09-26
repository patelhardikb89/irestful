<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Composers\Adapters\ComposerAdapter;
use iRESTful\Rodson\Domain\Inputs\Rodson;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteComposer;
use iRESTful\Rodson\Domain\Middles\Composers\Exceptions\ComposerException;

final class ConcreteComposerAdapter implements ComposerAdapter {
    private $baseFolder;
    public function __construct($baseFolder) {
        $this->baseFolder = $baseFolder;
    }

    public function fromDataToComposer(array $data) {

        if (!isset($data['rodson'])) {
            throw new ComposerException('The rodson keyname is mandatory in order to convert data to a Composer object.');
        }

        if (!isset($data['installation'])) {
            throw new ComposerException('The installation keyname is mandatory in order to convert data to a Composer object.');
        }

        $rodsonName = $data['rodson']->getName();

        $name = $rodsonName->getName();
        $type = $data['rodson']->getType();
        $homepage = $data['rodson']->getUrl();
        $license = $data['rodson']->getLicense();
        $authors = $data['rodson']->getAuthors();
        $baseNamespace = $rodsonName->getOrganizationName();

        return new ConcreteComposer($name, $type, $homepage, $license, $authors, $baseNamespace, $this->baseFolder, $data['installation']);

    }

}
