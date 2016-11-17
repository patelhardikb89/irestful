<?php
namespace iRESTful\Rodson\ClassesTests\Infrastructure\Adapters;
use iRESTful\Rodson\ClassesTests\Domain\Adapters\TestAdapter;
use iRESTful\Rodson\Annotations\Domain\Classes\AnnotatedClass;
use iRESTful\Rodson\ClassesTests\Infrastructure\Objects\ConcreteTest;
use iRESTful\Rodson\ClassesTests\Domain\Transforms\Adapters\TransformAdapter;
use iRESTful\Rodson\ClassesTests\Domain\Controllers\Adapters\ControllerAdapter;
use iRESTful\Rodson\ClassesTests\Domain\CRUDs\Adapters\CRUDAdapter;

final class ConcreteTestAdapter implements TestAdapter {
    private $transformAdapter;
    private $crudAdapter;
    private $controllerAdapter;
    public function __construct(TransformAdapter $transformAdapter, CRUDAdapter $crudAdapter, ControllerAdapter $controllerAdapter) {
        $this->transformAdapter = $transformAdapter;
        $this->crudAdapter = $crudAdapter;
        $this->controllerAdapter = $controllerAdapter;
    }

    public function fromDataToTests(array $data) {

        $transforms = $this->transformAdapter->fromDataToTransforms($data);
        $cruds = $this->crudAdapter->fromDataTOCRUDs($data);
        $controllers = $this->controllerAdapter->fromDataToControllers($data);

        $output = [];
        foreach($transforms as $oneTransform) {
            $output[] = new ConcreteTest($oneTransform);
        }

        foreach($controllers as $oneController) {
            $output[] = new ConcreteTest(null, $oneController);
        }

        foreach($cruds as $oneCRUD) {
            $output[] = new ConcreteTest(null, null, $oneCRUD);
        }

        return $output;
    }

}
