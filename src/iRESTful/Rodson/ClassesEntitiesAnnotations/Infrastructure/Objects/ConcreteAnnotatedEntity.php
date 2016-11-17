<?php
namespace iRESTful\Rodson\ClassesEntitiesAnnotations\Infrastructure\Objects;
use iRESTful\Rodson\ClassesEntitiesAnnotations\Domain\AnnotatedEntity;
use iRESTful\Rodson\ClassesEntities\Domain\Entity;
use iRESTful\Rodson\Annotations\Domain\Annotation;
use iRESTful\Rodson\ClassesEntitiesAnnotations\Domain\Exceptions\AnnotatedEntityException;
use iRESTful\Rodson\Classes\Domain\Samples\Sample;

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
