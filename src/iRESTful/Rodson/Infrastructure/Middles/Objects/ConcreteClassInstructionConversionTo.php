<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\To\To;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Container;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\To\Exceptions\ToException;

final class ConcreteClassInstructionConversionTo implements To {
    private $isData;
    private $isMultiple;
    private $isPartialSet;
    private $container;
    public function __construct($isData, $isMultiple, $isPartialSet, Container $container = null) {

        $isData = (bool) $isData;
        $amount = ($isData ? 1 : 0) + (empty($container) ? 0 : 1);
        if ($amount != 1) {
            throw new ToException('The to must be either data or an Container.  '.$amount.' given.');
        }

        $this->isData = $isData;
        $this->isMultiple = (bool) $isMultiple;
        $this->isPartialSet = (bool) $isPartialSet;
        $this->container = $container;
    }

    public function isData() {
        return $this->isData;
    }

    public function isMultiple() {
        return $this->isMultiple;
    }

    public function isPartialSet() {
        return $this->isPartialSet;
    }

    public function hasContainer() {
        return !empty($this->container);
    }

    public function getContainer() {
        return $this->container;
    }

    public function getData() {
        return [
            'is_data' => $this->isData(),
            'is_multiple' => $this->isMultiple()
        ];
    }

}
