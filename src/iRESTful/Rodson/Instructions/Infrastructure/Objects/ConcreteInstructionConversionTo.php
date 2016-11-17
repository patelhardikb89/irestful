<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Objects;
use iRESTful\Rodson\Instructions\Domain\Conversions\To\To;
use iRESTful\Rodson\Instructions\Domain\Containers\Container;
use iRESTful\Rodson\Instructions\Domain\Conversions\To\Exceptions\ToException;

final class ConcreteInstructionConversionTo implements To {
    private $isData;
    private $isMultiple;
    private $isPartialSet;
    private $container;
    public function __construct($isData, $isMultiple, $isPartialSet, Container $container = null) {

        $isData = (bool) $isData;
        $amount = ($isData ? 1 : 0) + ($isMultiple ? 1 : 0) + ($isPartialSet ? 1 : 0) + (empty($container) ? 0 : 1);

        if (
            !($amount == 1) &&
            !($isMultiple && ($amount == 2))
        ) {
            throw new ToException('The to must be either data, multiple, partialSet or a container.  It can also contain multiple + data, partialSet or a container.'.$amount.' given.');
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

}
