<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Annotations\AnnotatedEntity;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Entity;
use iRESTful\Rodson\Domain\Middles\Annotations\Annotation;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Annotations\Exceptions\AnnotatedEntityException;
use iRESTful\Rodson\Domain\Middles\Samples\Sample;

final class ConcreteSpecificClassEntityAnnotated implements AnnotatedEntity {
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

    public function getData() {

        $samples = $this->getSamples();
        array_walk($samples, function(&$element, $index) {
            $element = $element->getData();
        });

        return [
            'entity' => $this->entity->getData(),
            'annotation' => $this->annotation->getData(),
            'samples' => $samples
        ];
    }

}
