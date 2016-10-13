<?php
namespace iRESTful\Annotations\Infrastructure\Objects;
use iRESTful\Annotations\Domain\Parameters\Parameter;
use iRESTful\Annotations\Domain\Parameters\Flows\Flow;
use iRESTful\Annotations\Domain\Parameters\Types\Type;
use iRESTful\Annotations\Domain\Parameters\Converters\Converter;

final class ConcreteAnnotationParameter implements Parameter {
    private $flow;
    private $type;
    private $converter;
    private $elementsType;
    public function __construct(Flow $flow, Type $type, Converter $converter = null, $elementsType = null) {
        $this->flow = $flow;
        $this->type = $type;
        $this->converter = $converter;
        $this->elementsType = $elementsType;
    }

    public function getFlow() {
        return $this->flow;
    }

    public function getType() {
        return $this->type;
    }

    public function hasConverter() {
        return !empty($this->converter);
    }

    public function getConverter() {
        return $this->converter;
    }

    public function hasElementsType() {
        return !empty($this->elementsType);
    }

    public function getElementsType() {
        return $this->elementsType;
    }

}
