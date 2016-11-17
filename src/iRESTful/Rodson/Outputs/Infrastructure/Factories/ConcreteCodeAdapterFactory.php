<?php
namespace iRESTful\Rodson\Outputs\Infrastructure\Factories;
use iRESTful\Rodson\Outputs\Domain\Codes\Adapters\Factories\CodeAdapterFactory;
use iRESTful\Rodson\Outputs\Infrastructure\Adapters\ConcreteOutputCodeFileAdapter;
use iRESTful\Rodson\Outputs\Infrastructure\Adapters\ConcreteOutputCodePathAdapter;
use iRESTful\Rodson\Outputs\Infrastructure\Factories\TwigTemplateFactory;
use iRESTful\Rodson\Outputs\Infrastructure\Adapters\ConcreteCodeAdapter;

final class ConcreteCodeAdapterFactory implements CodeAdapterFactory {
    private $templateFolder;
    private $outputFolderPath;
    private $cacheFolder;
    private $baseFolder;
    private $webBaseFolder;
    public function __construct($templateFolder, $outputFolderPath, $baseFolder, $webBaseFolder, $cacheFolder = null) {
        $this->templateFolder = $templateFolder;
        $this->outputFolderPath = $outputFolderPath;
        $this->cacheFolder = $cacheFolder;
        $this->baseFolder = $baseFolder;
        $this->webBaseFolder = $webBaseFolder;
    }

    public function create() {
        $twigTemplateFactory = new TwigTemplateFactory($this->templateFolder, $this->cacheFolder);
        $template = $twigTemplateFactory->create();

        $classOutputPath = explode('/', $this->outputFolderPath);
        if (!empty($this->baseFolder)) {
            $baseFolderPath = explode('/', $this->baseFolder);
            $classOutputPath = array_merge($classOutputPath, $baseFolderPath);
        }

        $fileAdapter = new ConcreteOutputCodeFileAdapter();

        $rootOutput = array_filter(explode('/', $this->outputFolderPath));
        $rootPathAdapter = new ConcreteOutputCodePathAdapter($fileAdapter, $rootOutput);

        $indexOutput = array_merge($rootOutput, [$this->webBaseFolder]);
        $indexPathAdapter = new ConcreteOutputCodePathAdapter($fileAdapter, $indexOutput);

        $classOutput = array_filter($classOutputPath);
        $classPathAdapter = new ConcreteOutputCodePathAdapter($fileAdapter, $classOutput);
        return new ConcreteCodeAdapter($rootPathAdapter, $classPathAdapter, $indexPathAdapter, $template);
    }

}
