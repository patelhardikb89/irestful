<?php
namespace iRESTful\Annotations\Infrastructure\Adapters;
use iRESTful\Annotations\Domain\Adapters\AnnotationAdapter;
use iRESTful\ClassesEntities\Domain\Entity;
use iRESTful\Annotations\Domain\Parameters\Adapters\ParameterAdapter;
use iRESTful\Annotations\Infrastructure\Objects\ConcreteAnnotation;

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
