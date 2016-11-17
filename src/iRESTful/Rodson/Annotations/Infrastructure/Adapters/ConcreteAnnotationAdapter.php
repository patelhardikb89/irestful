<?php
namespace iRESTful\Rodson\Annotations\Infrastructure\Adapters;
use iRESTful\Rodson\Annotations\Domain\Adapters\AnnotationAdapter;
use iRESTful\Rodson\ClassesEntities\Domain\Entity;
use iRESTful\Rodson\Annotations\Domain\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\Annotations\Infrastructure\Objects\ConcreteAnnotation;

final class ConcreteAnnotationAdapter implements AnnotationAdapter {
    private $parameterAdapter;
    public function __construct(ParameterAdapter $parameterAdapter) {
        $this->parameterAdapter = $parameterAdapter;
    }

    public function fromEntityToAnnotation(Entity $entity) {
        $containerName = $entity->getEntity()->getObject()->getName();
        $parameters = $this->parameterAdapter->fromEntityToParameters($entity);
        return new ConcreteAnnotation($containerName, $parameters);
    }

}
