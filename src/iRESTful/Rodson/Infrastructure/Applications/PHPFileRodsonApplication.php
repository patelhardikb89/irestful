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
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteComposerAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteVagrantFileAdapter;

final class PHPFileRodsonApplication implements RodsonApplication {
    private $baseNamespace;
    private $templateFolder;
    private $cacheFolder;
    private $baseFolder;
    public function __construct($templateFolder, $cacheFolder = null, $baseFolder = 'src') {
        $this->templateFolder = $templateFolder;
        $this->cacheFolder = $cacheFolder;
        $this->baseFolder = $baseFolder;
    }

    public function executeByFolder($folderPath, $outputFolderPath) {

    }

    public function executeByFile($filePath, $outputFolderPath) {

        $repositoryFactory = new ConcreteRodsonRepositoryFactory();
        $repository = $repositoryFactory->create();
        $rodson = $repository->retrieve($filePath);

        $name = $rodson->getName();
        $baseNamespace = [
            $this->baseFolder,
            $name->getOrganizationName(),
            $name->getProjectName()
        ];

        $classAdapterFactory = new ConcreteSpecificClassAdapterFactory([
                $this->baseFolder,
                $name->getOrganizationName(),
                $name->getProjectName()
            ],
            '___',
            'America/Montreal'
        );

        $classAdapter = $classAdapterFactory->create();
        $classes = $classAdapter->fromRodsonToClasses($rodson);

        $composerAdapter = new ConcreteComposerAdapter($this->baseFolder);
        $composer = $composerAdapter->fromRodsonToComposer($rodson);

        $vagrantFileAdapter = new ConcreteVagrantFileAdapter();
        $vagrantFile = $vagrantFileAdapter->fromRodsonToVagrantFile($rodson);

        $output = array_filter(explode('/', $outputFolderPath));
        $twigTemplateFactory = new TwigTemplateFactory($this->templateFolder, $this->cacheFolder);

        $template = $twigTemplateFactory->create();
        $fileAdapter = new ConcreteOutputCodeFileAdapter();
        $pathAdapter = new ConcreteOutputCodePathAdapter($fileAdapter, $output);

        $codeAdapter = new ConcreteCodeAdapter($pathAdapter, $template);
        $classCodes = $codeAdapter->fromClassesToCodes($classes);
        $composerCode = $codeAdapter->fromComposerToCode($composer);
        $vagrantFileCode = $codeAdapter->fromVagrantFileToCode($vagrantFile);

        $service = new FileCodeService();
        $service->saveMultiple(array_merge($classCodes, [$composerCode], [$vagrantFileCode]));
    }

}
