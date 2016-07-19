<?php
namespace iRESTful\Rodson\Infrastructure\Services;
use iRESTful\Rodson\Domain\Services\RodsonService;
use iRESTful\Rodson\Domain\Rodson;
use iRESTful\Rodson\Domain\Outputs\Codes\Adapters\CodeAdapter;
use iRESTful\Rodson\Domain\Outputs\Classes\Adapters\ClassAdapter;
use iRESTful\Rodson\Domain\Outputs\Codes\Services\CodeService;

final class FileRodsonService implements RodsonService {
    private $classAdapter;
    private $codeAdapter;
    public function __construct(ClassAdapter $classAdapter, CodeAdapter $codeAdapter, CodeService $codeService) {
        $this->classAdapter = $classAdapter;
        $this->codeAdapter = $codeAdapter;
        $this->codeService = $codeService;
    }

    public function save(Rodson $rodson) {

        $objects = $rodson->getObjects();
        $controllers = $rodson->getControllers();

        $objectClasses = $this->classAdapter->fromObjectsToClasses($objects);

        $objectTypeClasses = $this->classAdapter->fromObjectsToTypeClasses($objects);
        $controllerClasses = [];//$this->classAdapter->fromControllersToClasses($controllers);
        $classes = array_merge($objectClasses, $objectTypeClasses, $controllerClasses);

        $codes = $this->codeAdapter->fromClassesToCodes($classes);
        $this->codeService->saveMultiple($codes);
    }

}
