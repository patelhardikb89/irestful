<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Adapters\TestAdapter;
use iRESTful\Rodson\Domain\Middles\Annotations\Classes\AnnotatedClass;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteSpecificClassTest;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Transforms\Adapters\TransformAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Controllers\Adapters\ControllerAdapter;

final class ConcreteSpecificClassTestAdapter implements TestAdapter {
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
            $output[] = new ConcreteSpecificClassTest($oneTransform);
        }

        foreach($controllers as $oneController) {
            $output[] = new ConcreteSpecificClassTest(null, $oneController);
        }

        return $output;
    }

}
