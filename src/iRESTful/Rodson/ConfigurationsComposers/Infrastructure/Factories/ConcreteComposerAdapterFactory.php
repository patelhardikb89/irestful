<?php
namespace iRESTful\Rodson\ConfigurationsComposers\Infrastructure\Factories;
use iRESTful\Rodson\ConfigurationsComposers\Domain\Adapters\Factories\ComposerAdapterFactory;
use iRESTful\Rodson\ConfigurationsComposers\Infrastructure\Adapters\ConcreteComposerAdapter;

final class ConcreteComposerAdapterFactory implements ComposerAdapterFactory {
    private $baseFolder;
    public function __construct($baseFolder) {
        $this->baseFolder = $baseFolder;
    }

    public function create() {
        return new ConcreteComposerAdapter($this->baseFolder);
    }

}
