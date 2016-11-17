<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Sets\Partials\Adapters\RequestPartialSetAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\Adapters\EntityPartialSetRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\EntityPartialSetRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Sets\Partials\Exceptions\RequestPartialSetException;

final class ConcreteRequestPartialSetAdapter implements RequestPartialSetAdapter {
    private $entityPartialSetRetrieverCriteriaAdapter;
    public function __construct(EntityPartialSetRetrieverCriteriaAdapter $entityPartialSetRetrieverCriteriaAdapter) {
        $this->entityPartialSetRetrieverCriteriaAdapter = $entityPartialSetRetrieverCriteriaAdapter;
    }

    public function fromDataToEntityPartialSetRequest(array $data) {
        try {

            $criteria = $this->entityPartialSetRetrieverCriteriaAdapter->fromDataToEntityPartialSetRetrieverCriteria($data);
            return $this->fromEntityPartialSetRetrieverCriteriaToRequest($criteria);

        } catch (EntityPartialSetException $exception) {
            throw new RequestPartialSetException('There was an exception while converting data to an EntityPartialSetRetrieverCriteria object.', $exception);
        }
    }

    public function fromDataToEntityPartialSetTotalAmountRequest(array $data) {
        try {

            $criteria = $this->entityPartialSetRetrieverCriteriaAdapter->fromDataToEntityPartialSetRetrieverCriteria($data);
            return $this->fromEntityPartialSetRetrieverCriteriaToTotalAmountRequest($criteria);

        } catch (EntityPartialSetException $exception) {
            throw new RequestPartialSetException('There was an exception while converting data to an EntityPartialSetRetrieverCriteria object.', $exception);
        }
    }

    public function fromEntityPartialSetRetrieverCriteriaToRequest(EntityPartialSetRetrieverCriteria $criteria) {

        $containerName = $criteria->getContainerName();
        $index = $criteria->getIndex();
        $amount = $criteria->getAmount();

        $orderBy = '';
        if ($criteria->hasOrdering()) {
            $ordering = $criteria->getOrdering();
            $orderBy = $this->fromOrderingToSubRequest($ordering);
        }

        return [
            'query' => 'select * from '.$containerName.$orderBy.' limit '.$index.','.$amount.';'
        ];

    }

    public function fromEntityPartialSetRetrieverCriteriaToTotalAmountRequest(EntityPartialSetRetrieverCriteria $criteria) {

        $containerName = $criteria->getContainerName();
        return [
            'query' => 'select count(1) as amount from '.$containerName
        ];

    }

    private function fromOrderingToSubRequest(Ordering $ordering) {
        $names = $ordering->getNames();
        $side = $ordering->isAscending() ? 'asc' : 'desc';
        return ' order by '.implode(', ', $names).' '.$side;
    }

}
