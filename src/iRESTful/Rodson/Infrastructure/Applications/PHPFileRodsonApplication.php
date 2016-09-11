<?php
namespace iRESTful\Rodson\Infrastructure\Applications;
use iRESTful\Rodson\Applications\RodsonApplication;
use iRESTful\Rodson\Infrastructure\Inputs\Factories\ConcreteRodsonRepositoryFactory;
use iRESTful\Rodson\Infrastructure\Middles\Factories\ConcreteSpecificClassAdapterFactory;
use iRESTful\Rodson\Infrastructure\Outputs\Services\FileCodeService;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteAnnotatedClassAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Factories\ConcreteAnnotationAdapterFactory;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteSampleAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteConfigurationAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Factories\ConcreteConfigurationNamespaceFactory;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteFunctionalTransformTestAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassNamespaceAdapter;
use iRESTful\Rodson\Infrastructure\Outputs\Factories\TwigTemplateFactory;
use iRESTful\Rodson\Infrastructure\Outputs\Adapters\ConcreteCodeAdapter;
use iRESTful\Rodson\Infrastructure\Outputs\Adapters\ConcreteOutputCodePathAdapter;
use iRESTful\Rodson\Infrastructure\Outputs\Adapters\ConcreteOutputCodeFileAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassControllerAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteSpecificClassEntityAnnotatedAdapter;

final class PHPFileRodsonApplication implements RodsonApplication {
    private $baseNamespace;
    private $twigTemplateFactory;
    private $repository;
    private $service;
    public function __construct(array $baseNamespace, $templateFolder, $cacheFolder = null) {

        $this->baseNamespace = $baseNamespace;
        $this->twigTemplateFactory = new TwigTemplateFactory($templateFolder, $cacheFolder);

        $repositoryFactory = new ConcreteRodsonRepositoryFactory();
        $this->repository = $repositoryFactory->create();

        $this->service = new FileCodeService();
    }

    public function executeByFolder($folderPath, $outputFolderPath) {

    }

    public function executeByFile($filePath, $outputFolderPath) {
        $rodson = $this->repository->retrieve([
            'file_path' => $filePath
        ]);

        $name = $rodson->getName();

        $baseNamespace = array_merge($this->baseNamespace, [$name]);

        $classAdapterFactory = new ConcreteSpecificClassAdapterFactory(
            $baseNamespace,
            '___',
            'America/Montreal'
        );

        $classAdapter = $classAdapterFactory->create();
        $classes = $classAdapter->fromRodsonToClasses($rodson);

        $output = array_filter(explode('/', $outputFolderPath));
        $template = $this->twigTemplateFactory->create();
        $fileAdapter = new ConcreteOutputCodeFileAdapter();
        $pathAdapter = new ConcreteOutputCodePathAdapter($fileAdapter, $output);

        $codeAdapter = new ConcreteCodeAdapter($pathAdapter, $template);
        $codes = $codeAdapter->fromClassesToCode($classes);
        $this->service->saveMultiple($codes);
    }

}
