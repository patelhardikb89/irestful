<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\To\To;
use iRESTful\Rodson\Domain\Middles\Annotations\Classes\AnnotatedClass;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\To\Exceptions\ToException;

final class ConcreteClassInstructionConversionTo implements To {
    private $isData;
    private $isMultiple;
    private $annotatedClass;
    public function __construct($isData, $isMultiple, AnnotatedClass $annotatedClass = null) {

        $isData = (bool) $isData;
        $amount = ($isData ? 1 : 0) + (empty($annotatedClass) ? 0 : 1);
        if ($amount != 1) {
            throw new ToException('The to must be either data or an AnnotatedClass.  '.$amount.' given.');
        }

        $this->isData = $isData;
        $this->isMultiple = (bool) $isMultiple;
        $this->annotatedClass = $annotatedClass;
    }

    public function isData() {
        return $this->isData;
    }

    public function isMultiple() {
        return $this->isMultiple;
    }

    public function hasAnnotatedClass() {
        return !empty($this->annotatedClass);
    }

    public function getAnnotatedClass() {
        return $this->annotatedClass;
    }

    public function getData() {
        return [
            'is_data' => $this->isData(),
            'is_multiple' => $this->isMultiple(),
            'annotated_class' => $this->getAnnotatedClass()->getData()
        ];
    }

}
