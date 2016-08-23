<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Annotations\Classes\AnnotatedClass;
use iRESTful\Rodson\Domain\Middles\Classes\ObjectClass;
use iRESTful\Rodson\Domain\Middles\Annotations\Annotation;
use iRESTful\Rodson\Domain\Middles\Samples\Sample;
use iRESTful\Rodson\Domain\Middles\Annotations\Classes\Exceptions\AnnotatedClassException;

final class ConcreteAnnotatedClass implements AnnotatedClass {
    private $class;
    private $annotation;
    private $samples;
    public function __construct(ObjectClass $class, Annotation $annotation = null, array $samples = null) {

        if (empty($samples)) {
            $samples = null;
        }

        if (!empty($samples)) {
            foreach($samples as $oneSample) {
                if (!($oneSample instanceof Sample)) {
                    throw new AnnotatedClassException('The samples array must only contain Sample objects.');
                }
            }
        }

        $this->class = $class;
        $this->annotation = $annotation;
        $this->samples = $samples;
    }

    public function getClass() {
        return $this->class;
    }

    public function hasAnnotation() {
        return !empty($this->annotation);
    }

    public function getAnnotation() {
        return $this->annotation;
    }

    public function hasSamples() {
        return !empty($this->samples);
    }

    public function getSamples() {
        return $this->samples;
    }

    public function getData() {

        $output = [
            'class' => $this->getClass()->getData()
        ];

        if ($this->hasAnnotation()) {
            $output['annotation'] = $this->getAnnotation()->getData();
        }

        if ($this->hasSamples()) {
            $samples = $this->getSamples();
            array_walk($samples, function(&$element, $index) {
                $element = $element->getData();
            });

            $output['samples'] = $samples;
        }

        return $output;
    }

}
