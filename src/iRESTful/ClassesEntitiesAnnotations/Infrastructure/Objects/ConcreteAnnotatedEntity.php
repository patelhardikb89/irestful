<?php
namespace iRESTful\ClassesEntitiesAnnotations\Infrastructure\Objects;
use iRESTful\ClassesEntitiesAnnotations\Domain\AnnotatedEntity;
use iRESTful\ClassesEntities\Domain\Entity;
use iRESTful\Annotations\Domain\Annotation;
use iRESTful\ClassesEntitiesAnnotations\Domain\Exceptions\AnnotatedEntityException;
use iRESTful\Classes\Domain\Samples\Sample;

final class ConcreteAnnotatedEntity implements AnnotatedEntity {
    private $entity;
    private $annotation;
    private $samples;
    public function __construct(Entity $entity, Annotation $annotation, array $samples) {

        if (empty($samples)) {
            throw new AnnotatedEntityException('The samples array cannot be empty.');
        }

        foreach($samples as $oneSample) {
            if (!($oneSample instanceof Sample)) {
                throw new AnnotatedEntityException('The samples array must only contain Sample objects.');
            }
        }

        $this->entity = $entity;
        $this->annotation = $annotation;
        $this->samples = $samples;
    }

    public function getEntity() {
        return $this->entity;
    }

    public function getAnnotation() {
        return $this->annotation;
    }

    public function getSamples() {
        return $this->samples;
    }

}
