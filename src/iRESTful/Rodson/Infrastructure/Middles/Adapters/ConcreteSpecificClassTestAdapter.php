<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Adapters\TestAdapter;
use iRESTful\Rodson\Domain\Middles\Annotations\Classes\AnnotatedClass;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteSpecificClassTest;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Transforms\Adapters\TransformAdapter;

final class ConcreteSpecificClassTestAdapter implements TestAdapter {
    private $transformAdapter;
    public function __construct(TransformAdapter $transformAdapter) {
        $this->transformAdapter = $transformAdapter;
    }

    public function fromDataToTests(array $data) {
        $output = [];
        $transforms = $this->transformAdapter->fromDataToTransforms($data);
        foreach($transforms as $oneTransform) {
            $output[] = new ConcreteSpecificClassTest($oneTransform);
        }

        return $output;
    }

}
