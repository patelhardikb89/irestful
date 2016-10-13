<?php
namespace iRESTful\ClassesTests\Infrastructure\Objects;
use iRESTful\ClassesTests\Domain\Transforms\Transform;
use iRESTful\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\ClassesConfigurations\Domain\Configuration;
use iRESTful\Classes\Domain\Samples\Sample;
use iRESTful\Classes\Domain\Tests\Functionals\Exceptions\TransformException;

final class ConcreteTestTransform implements Transform {
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

}
