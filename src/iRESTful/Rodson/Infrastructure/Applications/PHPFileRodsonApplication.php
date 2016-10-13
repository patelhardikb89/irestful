<?php
namespace iRESTful\Rodson\Infrastructure\Applications;
use iRESTful\Rodson\Applications\RodsonApplication;
use iRESTful\DSLs\Infrastructure\Factories\ConcreteRodsonRepositoryFactory;
use iRESTful\Rodson\Infrastructure\Middles\Factories\ConcreteSpecificClassAdapterFactory;
use iRESTful\Rodson\Infrastructure\Outputs\Services\FileCodeService;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteAnnotatedClassAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Factories\ConcreteAnnotationAdapterFactory;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteSampleAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteObjectConfigurationAdapter;
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
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcretePHPUnitAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteInstallationAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Factories\ConcreteInstallationNamespaceFactory;

final class PHPFileRodsonApplication implements RodsonApplication {
    private $baseNamespace;
    private $templateFolder;
    private $cacheFolder;
    private $baseFolder;
    private $webBaseFolder;
    public function __construct($templateFolder, $cacheFolder = null, $baseFolder = 'src', $webBaseFolder = 'web') {
        $this->templateFolder = $templateFolder;
        $this->cacheFolder = $cacheFolder;
        $this->baseFolder = $baseFolder;
        $this->webBaseFolder = $webBaseFolder;
    }

    public function executeByFolder($folderPath, $outputFolderPath) {

    }

    public function executeByFile($filePath, $outputFolderPath) {

        $getInstallation = function(array $classes) {
            foreach($classes as $oneClass) {
                if ($oneClass->hasInstallation()) {
                    return $oneClass->getInstallation();
                }
            }

            return null;
        };

        $repositoryFactory = new ConcreteRodsonRepositoryFactory();
        $repository = $repositoryFactory->create();
        $rodson = $repository->retrieve($filePath);

        $name = $rodson->getName();
        $baseNamespace = [
            $name->getOrganizationName(),
            $name->getProjectName()
        ];

        $classAdapterFactory = new ConcreteSpecificClassAdapterFactory(
            $baseNamespace,
            '___',
            'America/Montreal'
        );

        $classAdapter = $classAdapterFactory->create();
        $classes = $classAdapter->fromRodsonToClasses($rodson);

        $installation = $getInstallation($classes);

        $composerAdapter = new ConcreteComposerAdapter($this->baseFolder);
        $composer = $composerAdapter->fromDataToComposer([
            'rodson' => $rodson,
            'installation' => $installation
        ]);

        $vagrantFileAdapter = new ConcreteVagrantFileAdapter();
        $vagrantFile = $vagrantFileAdapter->fromRodsonToVagrantFile($rodson);

        $phpunitAdapter = new ConcretePHPUnitAdapter();
        $phpunit = $phpunitAdapter->fromRodsonToPHPUnit($rodson);

        $twigTemplateFactory = new TwigTemplateFactory($this->templateFolder, $this->cacheFolder);

        $template = $twigTemplateFactory->create();
        $fileAdapter = new ConcreteOutputCodeFileAdapter();

        $classOutputPath = explode('/', $outputFolderPath);
        if (!empty($this->baseFolder)) {
            $baseFolderPath = explode('/', $this->baseFolder);
            $classOutputPath = array_merge($classOutputPath, $baseFolderPath);
        }

        $rootOutput = array_filter(explode('/', $outputFolderPath));
        $indexOutput = array_merge($rootOutput, [$this->webBaseFolder]);
        $indexPathAdapter = new ConcreteOutputCodePathAdapter($fileAdapter, $indexOutput);

        $classOutput = array_filter($classOutputPath);
        $classPathAdapter = new ConcreteOutputCodePathAdapter($fileAdapter, $classOutput);
        $classCodeAdapter = new ConcreteCodeAdapter($classPathAdapter, $indexPathAdapter, $template);
        $classCodes = $classCodeAdapter->fromClassesToCodes($classes);

        $rootPathAdapter = new ConcreteOutputCodePathAdapter($fileAdapter, $rootOutput);
        $rootCodeAdapter = new ConcreteCodeAdapter($rootPathAdapter, $indexPathAdapter, $template);
        $composerCode = $rootCodeAdapter->fromComposerToCode($composer);
        $vagrantFileCode = $rootCodeAdapter->fromVagrantFileToCode($vagrantFile);
        $phpunitCode = $rootCodeAdapter->fromPHPUnitToCode($phpunit);


        $service = new FileCodeService();
        $service->saveMultiple(array_merge($classCodes, [$composerCode, $vagrantFileCode, $phpunitCode]));
    }

}
