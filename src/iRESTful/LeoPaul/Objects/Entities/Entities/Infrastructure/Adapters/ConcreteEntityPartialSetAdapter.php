<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\EntityPartialSetAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\EntityPartialSet;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\ConcreteEntityPartialSet;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;

final class ConcreteEntityPartialSetAdapter implements EntityPartialSetAdapter {

    private $entityAdapter;
    public function __construct(EntityAdapter $entityAdapter) {
        $this->entityAdapter = $entityAdapter;
    }

    public function fromDataToEntityPartialSet(array $data) {

        if (!isset($data['index'])) {
            throw new EntityPartialSetException('The index keyname is mandatory in order to convert the data to an EntityPartialSet object.');
        }

        if (!isset($data['total_amount'])) {
            throw new EntityPartialSetException('The total_amount keyname is mandatory in order to convert the data to an EntityPartialSet object.');
        }

        $entities = null;
        if (isset($data['entities']) && !empty($data['entities'])) {
            $entities = $this->organizeEntities($data['entities']);
        }

        $index = (int) $data['index'];
        $totalAmount = (int) $data['total_amount'];
        return new ConcreteEntityPartialSet($index, $totalAmount, $entities);

    }

    public function fromEntityPartialSetToData(EntityPartialSet $entityPartialSet) {

        $output = array(
            'index' => $entityPartialSet->getIndex(),
            'amount' => $entityPartialSet->getAmount(),
            'total_amount' => $entityPartialSet->getTotalAmount()
        );

        try {

            if ($entityPartialSet->hasEntities()) {
                $entities = $entityPartialSet->getEntities();
                $output['entities'] = $this->entityAdapter->fromEntitiesToData($entities, true);
            }

            return $output;

        } catch (EntityException $exception) {
            throw new EntityPartialSetException('There was an exception while converting Entity objects to data.', $exception);
        }
    }

    private function organizeEntities(array $entities) {
        $keys = array_keys($entities);
        $first = $entities[$keys[0]];
        if (is_array($first)) {
            return $this->entityAdapter->fromDataToEntities($entities);
        }

        if ($first instanceof Entity) {
            return $entities;
        }

        throw new EntityPartialSetException('The entities keyname must either contain data or Entity objects.');
    }

}
