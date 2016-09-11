<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Transforms\Transform;
use iRESTful\Rodson\Domain\Middles\Namespaces\ClassNamespace;
use iRESTful\Rodson\Domain\Middles\Configurations\Configuration;
use iRESTful\Rodson\Domain\Middles\Samples\Sample;
use iRESTful\Rodson\Domain\Middles\Tests\Functionals\Exceptions\TransformException;

final class ConcreteSpecificClassTestTransform implements Transform {
    private $namespace;
    private $samples;
    private $configuration;
    public function __construct(ClassNamespace $namespace, array $samples, Configuration $configuration) {

        if (empty($samples)) {
            throw new TransformException('The samples array cannot be empty.');
        }

        foreach($samples as $oneSample) {
            if (!($oneSample instanceof Sample)) {
                throw new TransformException('The samples array must only contain Sample objects.');
            }
        }

        $this->namespace = $namespace;
        $this->samples = $samples;
        $this->configuration = $configuration;

    }

    public function getNamespace() {
        return $this->namespace;
    }

    public function getSamples() {
        return $this->samples;
    }

    public function getConfiguration() {
        return $this->configuration;
    }

    public function getData() {

        $samples = $this->getSamples();
        array_walk($samples, function(&$element, $index) {
            $element = $element->getData();
        });

        return [
            'namespace' => $this->getNamespace()->getData(),
            'samples' => $samples,
            'configuration' => $this->getConfiguration()->getData()
        ];
    }

}
