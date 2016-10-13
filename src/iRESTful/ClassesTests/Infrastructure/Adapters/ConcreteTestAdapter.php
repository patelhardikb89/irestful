<?php
namespace iRESTful\ClassesTests\Infrastructure\Adapters;
use iRESTful\ClassesTests\Domain\Adapters\TestAdapter;
use iRESTful\Annotations\Domain\Classes\AnnotatedClass;
use iRESTful\ClassesTests\Infrastructure\Objects\ConcreteTest;
use iRESTful\ClassesTests\Domain\Transforms\Adapters\TransformAdapter;
use iRESTful\ClassesTests\Domain\Controllers\Adapters\ControllerAdapter;

final class ConcreteTestAdapter implements TestAdapter {
    private $transformAdapter;
    private $controllerAdapter;
    public function __construct(TransformAdapter $transformAdapter, ControllerAdapter $controllerAdapter) {
        $this->transformAdapter = $transformAdapter;
        $this->controllerAdapter = $controllerAdapter;
    }

    public function fromDataToTests(array $data) {

        $transforms = $this->transformAdapter->fromDataToTransforms($data);
        $controllers = $this->controllerAdapter->fromDataToControllers($data);

        $output = [];
        foreach($transforms as $oneTransform) {
            $output[] = new ConcreteTest($oneTransform);
        }

        foreach($controllers as $oneController) {
            $output[] = new ConcreteTest(null, $oneController);
        }

        return $output;
    }

}
