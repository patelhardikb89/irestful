<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Sets\Partials\Adapters\RequestPartialSetAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\EntityPartialSetRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Adapters\OrderingAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Sets\Partials\Exceptions\RequestPartialSetException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Exceptions\OrderingException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\Adapters\EntityPartialSetRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class ConcreteRequestPartialSetAdapter implements RequestPartialSetAdapter {
    private $entityPartialSetRetrieverCriteriaAdapter;
    private $orderingAdapter;
    private $port;
    private $headers;
    public function __construct(EntityPartialSetRetrieverCriteriaAdapter $entityPartialSetRetrieverCriteriaAdapter, OrderingAdapter $orderingAdapter, $port = 80, array $headers = null) {
        $this->entityPartialSetRetrieverCriteriaAdapter = $entityPartialSetRetrieverCriteriaAdapter;
        $this->orderingAdapter = $orderingAdapter;
        $this->port = $port;
        $this->headers = $headers;
    }

    public function fromDataToEntityPartialSetHttpRequestData(array $data) {

        try {

            $criteria = $this->entityPartialSetRetrieverCriteriaAdapter->fromDataToEntityPartialSetRetrieverCriteria($data);
            return $this->fromEntityPartialSetRetrieverCriteriaToHttpRequestData($criteria);

        } catch (EntityPartialSetException $exception) {
            throw new RequestPartialSetException('There was an exception while converting data to an EntityPartialSetRetrieverCriteria object.', $exception);
        }
    }

    public function fromEntityPartialSetRetrieverCriteriaToHttpRequestData(EntityPartialSetRetrieverCriteria $criteria) {

        $createParams = function() use(&$criteria) {

            $index = $criteria->getIndex();
            $amount = $criteria->getAmount();

            $output = [
                'index' => $index,
                'amount' => $amount
            ];

            if ($criteria->hasOrdering()) {
                $ordering = $criteria->getOrdering();
                $output['ordering'] = $this->orderingAdapter->fromOrderingToData($ordering);
            }

            return $output;
        };

        try {

            $containerName = $criteria->getContainerName();


            $uri = '/'.$containerName.'/partials';
            $params = $createParams();

            return [
                'uri' => $uri,
                'query_parameters' => $params,
                'method' => 'get',
                'port' => $this->port,
                'headers' => $this->headers
            ];

        } catch (OrderingException $exception) {
            throw new RequestPartialSetException('There was an exception while converting an Ordering object to data.', $exception);
        }


    }

}
