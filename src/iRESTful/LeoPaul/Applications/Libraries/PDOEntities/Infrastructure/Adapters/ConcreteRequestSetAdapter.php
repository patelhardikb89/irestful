<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\Adapters\EntitySetRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Sets\Adapters\RequestSetAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\EntitySetRetrieverCriteria;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Sets\Exceptions\RequestSetException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Exceptions\UuidException;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering;

final class ConcreteRequestSetAdapter implements RequestSetAdapter {
    private $entitySetRetrieverCriteriaAdapter;
    private $uuidAdapter;
    public function __construct(EntitySetRetrieverCriteriaAdapter $entitySetRetrieverCriteriaAdapter, UuidAdapter $uuidAdapter) {
        $this->entitySetRetrieverCriteriaAdapter = $entitySetRetrieverCriteriaAdapter;
        $this->uuidAdapter = $uuidAdapter;
    }

    public function fromDataToEntitySetRequest(array $data) {
        try {

            $criteria = $this->entitySetRetrieverCriteriaAdapter->fromDataToEntitySetRetrieverCriteria($data);
            return $this->fromEntitySetRetrieverCriteriaToRequest($criteria);

        } catch (EntitySetException $exception) {
            throw new RequestSetException('There was an exception while converting data to an EntitySetRetrieverCriteria object.', $exception);
        }
    }

    public function fromEntitySetRetrieverCriteriaToRequest(EntitySetRetrieverCriteria $criteria) {
        $containerName = $criteria->getContainerName();

        $orderBy = '';
        if ($criteria->hasOrdering()) {
            $ordering = $criteria->getOrdering();
            $orderBy = $this->fromOrderingToSubRequest($ordering);
        }

        try {

            if ($criteria->hasUuids()) {
                $uuids = $criteria->getUuids();
                $binaries = $this->uuidAdapter->fromUuidsToBinaryStrings($uuids);

                $keys = array_keys($binaries);
                $keysWithSemiColon = array_map(function($oneKeyname) {
                    return ':'.$oneKeyname;
                }, $keys);

                return [
                    'query' => 'select * from '.$containerName.' where uuid IN('.implode(', ', $keysWithSemiColon).')'.$orderBy.';',
                    'params' => $binaries
                ];

            }

            if ($criteria->hasKeyname()) {
                $keyname = $criteria->getKeyname();
                $name = $keyname->getName();
                $nameWithSemicolon = ':'.$name;
                $value = $keyname->getValue();

                return [
                    'query' => 'select * from '.$containerName.' where '.$name.' = '.$nameWithSemicolon.$orderBy.';',
                    'params' => [
                        $name => $value
                    ]
                ];

            }

            throw new RequestSetException('There must be at least 1 retriever criteria in order to convert an EntitySetRetrieverCriteria object to a request.');

        } catch (UuidException $exception) {
            throw new RequestSetException('There was an exception while converting uuids to binary strings.', $exception);
        }
    }

    private function fromOrderingToSubRequest(Ordering $ordering) {
        $names = $ordering->getNames();
        $side = $ordering->isAscending() ? 'asc' : 'desc';
        return ' order by '.implode(', ', $names).' '.$side;
    }

}
