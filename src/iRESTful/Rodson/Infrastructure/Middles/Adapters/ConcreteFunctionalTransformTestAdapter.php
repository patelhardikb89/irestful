<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Tests\Functionals\Transforms\Adapters\TransformTestAdapter;
use iRESTful\Rodson\Domain\Middles\Configurations\Configuration;
use iRESTful\Rodson\Domain\Middles\Annotations\Classes\AnnotatedClass;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteNamespace;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteFunctionalTransformTest;

final class ConcreteFunctionalTransformTestAdapter implements TransformTestAdapter {
    private $baseNamespaces;
    private $configuration;
    public function __construct(array $baseNamespaces, Configuration $configuration) {
        $this->baseNamespaces = $baseNamespaces;
        $this->configuration = $configuration;
    }

    public function fromAnnotatedClassesToTransformTests(array $annotatedClasses) {

        $output = [];
        foreach($annotatedClasses as $oneAnnotatedClass) {

            if (!$oneAnnotatedClass->hasSamples()) {
                continue;
            }

            if (!$oneAnnotatedClass->getClass()->getInterface()->isEntity()) {
                continue;
            }

            $output[] = $this->fromAnnotatedClassToTransformTest($oneAnnotatedClass);
        }

        return $output;

    }

    private function fromAnnotatedClassToTransformTest(AnnotatedClass $annotatedClass) {

        $name = $annotatedClass->getClass()->getInterface()->getNamespace()->getName().'Test';
        $namespace = new ConcreteNamespace(array_merge($this->baseNamespaces, [
            'Tests',
            'Tests',
            'Functional',
            'Entities',
            $name
        ]));

        $samples = $annotatedClass->getSamples();
        return new ConcreteFunctionalTransformTest($namespace, $samples, $this->configuration);
    }

}
