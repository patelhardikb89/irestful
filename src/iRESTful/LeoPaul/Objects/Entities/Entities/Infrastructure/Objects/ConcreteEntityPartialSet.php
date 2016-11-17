<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\EntityPartialSet;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class ConcreteEntityPartialSet implements EntityPartialSet {
    private $entities;
    private $index;
    private $totalAmount;
    public function __construct($index, $totalAmount, array $entities = null) {

        if (!empty($entities)) {
            foreach($entities as $oneEntity) {
                if (!($oneEntity instanceof \iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity)) {
                    throw new EntityPartialSetException('The entities array must only contain Entity objects.');
                }
            }
        }

        if (!is_integer($index)) {
            throw new EntityPartialSetException('The index must be an integer.');
        }

        if ($index < 0) {
            throw new EntityPartialSetException('The index must be greater or equal to 0.');
        }

        if (!is_integer($totalAmount)) {
            throw new EntityPartialSetException('The totalAmount must be an integer.');
        }

        if ($totalAmount < 0) {
            throw new EntityPartialSetException('The totalAmount must be greater or equal to 0.');
        }

        $amount = empty($entities) ? 0 : count($entities);
        if ($totalAmount < ($index + $amount)) {
            throw new EntityPartialSetException('The totalAmount must be greater or equal to (index + amount).');
        }

        $this->entities = $entities;
        $this->index = $index;
        $this->amount = $amount;
        $this->totalAmount = $totalAmount;

    }

    public function hasEntities() {
        return !empty($this->entities);
    }

    public function getEntities() {
        return $this->entities;
    }

    public function getIndex() {
        return $this->index;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getTotalAmount() {
        return $this->totalAmount;
    }

}
