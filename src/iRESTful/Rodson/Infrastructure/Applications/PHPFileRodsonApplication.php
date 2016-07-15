<?php
namespace iRESTful\Rodson\Infrastructure\Applications;
use iRESTful\Rodson\Applications\RodsonApplication;
use iRESTful\Rodson\Infrastructure\Factories\ConcreteRodsonRepositoryFactory;
use iRESTful\Rodson\Infrastructure\Factories\PHPFileRodsonServiceFactory;

final class PHPFileRodsonApplication implements RodsonApplication {
    private $interfaceBaseNamespace;
    private $classBaseNamespace;
    private $repository;
    public function __construct(array $baseNamespace) {
        $this->interfaceBaseNamespace = array_merge($baseNamespace, ['Domain']);
        $this->classBaseNamespace = array_merge($baseNamespace, ['Infrastructure']);
        $repositoryFactory = new ConcreteRodsonRepositoryFactory();
        $this->repository = $repositoryFactory->create();
    }

    public function executeByFolder($folderPath, $outputFolderPath) {

    }

    public function executeByFile($filePath, $outputFolderPath) {
        $rodson = $this->repository->retrieve([
            'file_path' => $filePath
        ]);

        $output = array_filter(explode('/', $outputFolderPath));
        $serviceFactory = new PHPFileRodsonServiceFactory($this->interfaceBaseNamespace, $this->classBaseNamespace, $output);
        $serviceFactory->create()->save($rodson);
    }

}
