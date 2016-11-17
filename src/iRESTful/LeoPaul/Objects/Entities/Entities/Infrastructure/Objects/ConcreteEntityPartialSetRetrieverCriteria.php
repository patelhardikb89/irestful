<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\EntityPartialSetRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering;

final class ConcreteEntityPartialSetRetrieverCriteria implements EntityPartialSetRetrieverCriteria {
    private $containerName;
    private $index;
    private $amount;
    private $ordering;
    public function __construct($containerName, $index, $amount, Ordering $ordering = null) {

        if (!is_string($containerName) || empty($containerName)) {
            throw new EntityPartialSetException('The containerName must be a non-empty string.');
        }

        if (!is_integer($index)) {
            throw new EntityPartialSetException('The index must be an integer.');
        }

        if (!is_integer($amount)) {
            throw new EntityPartialSetException('The amount must be an integer.');
        }

        if ($amount <= 0) {
            throw new EntityPartialSetException('The amount must be greater than 0.');
        }

        if ($index < 0) {
            throw new EntityPartialSetException('The index must be greater or equal to 0.');
        }

        $this->containerName = $containerName;
        $this->index = $index;
        $this->amount = $amount;
        $this->ordering = $ordering;

    }

    public function getContainerName() {
        return $this->containerName;
    }

    public function getIndex() {
        return $this->index;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function hasOrdering() {
        return !empty($this->ordering);
    }

    public function getOrdering() {
        return $this->ordering;
    }

}
