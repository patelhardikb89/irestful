<?php
namespace iRESTful\Rodson\Outputs\Infrastructure\Factories;
use iRESTful\Rodson\Outputs\Domain\Codes\Factories\Factories\CodeFactoryFactory;
use iRESTful\Rodson\Outputs\Infrastructure\Factories\ConcreteCodeFactory;
use iRESTful\Rodson\Outputs\Infrastructure\Adapters\ConcreteOutputCodePathAdapter;
use iRESTful\Rodson\Outputs\Infrastructure\Adapters\ConcreteOutputCodeFileAdapter;
use iRESTful\Rodson\Outputs\Infrastructure\Factories\TwigTemplateFactory;

final class ConcreteCodeFactoryFactory implements CodeFactoryFactory {
    private $templateFolder;
    private $outputFolderPath;
    private $cacheFolder;
    public function __construct($templateFolder, $outputFolderPath, $cacheFolder = null) {
        $this->templateFolder = $templateFolder;
        $this->outputFolderPath = $outputFolderPath;
        $this->cacheFolder = $cacheFolder;
    }

    public function create() {

        $twigTemplateFactory = new TwigTemplateFactory($this->templateFolder, $this->cacheFolder);
        $template = $twigTemplateFactory->create();

        $fileAdapter = new ConcreteOutputCodeFileAdapter();

        $rootOutput = array_filter(explode('/', $this->outputFolderPath));
        $rootPathAdapter = new ConcreteOutputCodePathAdapter($fileAdapter, $rootOutput);

        return new ConcreteCodeFactory($rootPathAdapter, $template);
    }

}
