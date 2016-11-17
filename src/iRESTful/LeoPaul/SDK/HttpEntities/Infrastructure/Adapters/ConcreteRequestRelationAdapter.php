<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Relations\Adapters\RequestRelationAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\EntityRelationRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\Adapters\EntityRelationRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Relations\Exceptions\RequestRelationException;

final class ConcreteRequestRelationAdapter implements RequestRelationAdapter {
    private $entityRelationRetrieverCriteriaAdapter;
    private $port;
    private $headers;
    public function __construct(EntityRelationRetrieverCriteriaAdapter $entityRelationRetrieverCriteriaAdapter, $port = 80, array $headers = null) {
        $this->entityRelationRetrieverCriteriaAdapter = $entityRelationRetrieverCriteriaAdapter;
        $this->port = $port;
        $this->headers = $headers;
    }

    public function fromDataToEntityRelationHttpRequestData(array $data) {

        try {

            $criteria = $this->entityRelationRetrieverCriteriaAdapter->fromDataToEntityRelationRetrieverCriteria($data);
            return $this->fromEntityRelationRetrieverCriteriaToHttpRequestData($criteria);

        } catch (EntityRelationException $exception) {
            throw new RequestRelationException('There was an exception while converting data to an EntityRelationRetrieverCritria object.', $exception);
        }
    }

    public function fromEntityRelationRetrieverCriteriaToHttpRequestData(EntityRelationRetrieverCriteria $criteria) {

        $masterContainerName = $criteria->getMasterContainerName();
        $slaveContainerName = $criteria->getSlaveContainerName();
        $slavePropertyName = $criteria->getSlavePropertyName();
        $masterUuid = $criteria->getMasterUuid()->getHumanReadable();

        $uri = '/'.$masterContainerName.'/'.$masterUuid.'/'.$slavePropertyName.'/'.$slaveContainerName;
        return [
            'uri' => $uri,
            'method' => 'get',
            'port' => $this->port,
            'headers' => $this->headers
        ];

    }

}
