<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Relations\Adapters\RequestRelationAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\EntityRelationRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\Adapters\EntityRelationRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Relations\Exceptions\RequestRelationException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;

final class ConcreteRequestRelationAdapter implements RequestRelationAdapter {
    private $entityRelationRetrieverCriteriaAdapter;
    public function __construct(EntityRelationRetrieverCriteriaAdapter $entityRelationRetrieverCriteriaAdapter) {
        $this->entityRelationRetrieverCriteriaAdapter = $entityRelationRetrieverCriteriaAdapter;
    }

    public function fromDataToEntityRelationRequest(array $data) {
        try {

            $criteria = $this->entityRelationRetrieverCriteriaAdapter->fromDataToEntityRelationRetrieverCriteria($data);
            return $this->fromEntityRelationRetrieverCriteriaToRequest($criteria);

        } catch (EntityRelationException $exception) {
            throw new RequestRelationException('There was an exception while converting data to an EntityRelationRetrieverCriteria object.', $exception);
        }
    }

    public function fromEntityRelationRetrieverCriteriaToRequest(EntityRelationRetrieverCriteria $criteria) {

        $masterContainerName = $criteria->getMasterContainerName();
        $slaveContainerName = $criteria->getSlaveContainerName();
        $slavePropertyName = $criteria->getSlavePropertyName();
        $masterUuid = $criteria->getMasterUuid()->get();

        $table = $masterContainerName.'___'.$slavePropertyName;
        $query = '
                    select '.$slaveContainerName.'.* from '.$table.'
                    inner join '.$slaveContainerName.' on '.$table.'.slave_uuid = '.$slaveContainerName.'.uuid
                    where '.$table.'.master_uuid = :master_uuid;
        ';

        return [
            'query' => $query,
            'params' => ['master_uuid' => $masterUuid]
        ];

    }

}
