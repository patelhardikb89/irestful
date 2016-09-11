<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Transforms\Adapters\TransformAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Annotations\AnnotatedEntity;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteNamespace;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteSpecificClassTestTransform;
use iRESTful\Rodson\Domain\Middles\Configurations\Adapters\ConfigurationAdapter;
use iRESTful\Rodson\Domain\Middles\Configurations\Configuration;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Transforms\Exceptions\TransformException;

final class ConcreteSpecificClassTestTransformAdapter implements TransformAdapter {
    private $baseNamespaces;
    private $configurationAdapter;
    public function __construct(ConfigurationAdapter $configurationAdapter, array $baseNamespaces) {
        $this->configurationAdapter = $configurationAdapter;
        $this->baseNamespaces = $baseNamespaces;
    }

    public function fromDataToTransforms(array $data) {

        if (!isset($data['annotated_entities'])) {
            throw new TransformException('The annotated_entities keyname is mandatory in order to convert data to Transform objects.');
        }

        $output = [];
        $configuration = $this->configurationAdapter->fromDataToConfiguration($data);
        foreach($data['annotated_entities'] as $oneAnnotatedEntity) {
            $output[] = $this->fromAnnotatedEntityToTransform($oneAnnotatedEntity, $configuration);
        }

        return $output;

    }

    private function fromAnnotatedEntityToTransform(AnnotatedEntity $annotatedEntity, Configuration $configuration) {

        $name = $annotatedEntity->getEntity()->getInterface()->getNamespace()->getName().'Test';
        $namespace = new ConcreteNamespace(array_merge($this->baseNamespaces, [
            'Tests',
            'Tests',
            'Functional',
            'Entities',
            $name
        ]));

        $samples = $annotatedEntity->getSamples();
        return new ConcreteSpecificClassTestTransform($namespace, $samples, $configuration);
    }

}
