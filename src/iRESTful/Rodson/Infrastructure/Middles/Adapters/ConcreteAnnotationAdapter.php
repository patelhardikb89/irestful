<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Annotations\Adapters\AnnotationAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Entity;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteAnnotation;

final class ConcreteAnnotationAdapter implements AnnotationAdapter {
    private $parameterAdapter;
    public function __construct(ParameterAdapter $parameterAdapter) {
        $this->parameterAdapter = $parameterAdapter;
    }

    public function fromEntityToAnnotation(Entity $entity) {
        $containerName = $entity->getObject()->getName();
        $parameters = $this->parameterAdapter->fromEntityToParameters($entity);
        return new ConcreteAnnotation($containerName, $parameters);
    }

}
