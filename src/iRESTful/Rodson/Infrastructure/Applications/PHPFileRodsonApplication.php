<?php
namespace iRESTful\Rodson\Infrastructure\Applications;
use iRESTful\Rodson\Applications\RodsonApplication;
use iRESTful\Rodson\Infrastructure\Inputs\Factories\ConcreteRodsonRepositoryFactory;
use iRESTful\Rodson\Infrastructure\Middles\Factories\ConcreteClassAdapterFactory;
use iRESTful\Rodson\Infrastructure\Outputs\Factories\PHPCodeAdapterFactory;
use iRESTful\Rodson\Infrastructure\Outputs\Services\FileCodeService;

final class PHPFileRodsonApplication implements RodsonApplication {
    private $baseNamespace;
    private $repository;
    private $service;
    public function __construct(array $baseNamespace) {

        $this->baseNamespace = $baseNamespace;

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
        $classAdapterFactory = new ConcreteClassAdapterFactory($baseNamespace);
        $classAdapter = $classAdapterFactory->create();

        $classes = $classAdapter->fromRodsonToClasses($rodson);

        $output = array_filter(explode('/', $outputFolderPath));
        $codeAdapterFactory = new PHPCodeAdapterFactory($output);
        $this->codeAdapter = $codeAdapterFactory->create();

        $codes = $this->codeAdapter->fromClassesToCodes($classes);

        $this->service->saveMultiple($codes);
    }

}
