<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Sets\Adapters\RequestSetAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\EntitySetRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Adapters\OrderingAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Sets\Exceptions\RequestSetException;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Exceptions\UuidException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\Adapters\EntitySetRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Exceptions\OrderingException;

final class ConcreteRequestSetAdapter implements RequestSetAdapter {
    private $entitySetRetrieverCriteriaAdapter;
    private $uuidAdapter;
    private $orderingAdapter;
    private $port;
    private $headers;
    public function __construct(
        EntitySetRetrieverCriteriaAdapter $entitySetRetrieverCriteriaAdapter,
        UuidAdapter $uuidAdapter,
        OrderingAdapter $orderingAdapter,
        $port = 80,
        array $headers = null
    ) {
        $this->entitySetRetrieverCriteriaAdapter = $entitySetRetrieverCriteriaAdapter;
        $this->uuidAdapter = $uuidAdapter;
        $this->orderingAdapter = $orderingAdapter;
        $this->port = $port;
        $this->headers = $headers;
    }

    public function fromDataToEntitySetHttpRequestData(array $data) {

        try {

            $criteria = $this->entitySetRetrieverCriteriaAdapter->fromDataToEntitySetRetrieverCriteria($data);
            return $this->fromEntitySetRetrieverCriteriaToHttpRequestData($criteria);

        } catch (EntitySetException $exception) {
            throw new RequestSetException('There was an exception while converting data to an EntitySetRetrieverCriteria object.', $exception);
        }
    }

    public function fromEntitySetRetrieverCriteriaToHttpRequestData(EntitySetRetrieverCriteria $criteria) {

        $uuidAdapter = $this->uuidAdapter;
        $orderingAdpater = $this->orderingAdapter;
        $createRequestParams = function() use(&$criteria, &$uuidAdapter, &$orderingAdpater) {

            $orderingData = null;
            if ($criteria->hasOrdering()) {
                $ordering = $criteria->getOrdering();
                $orderingData = $orderingAdpater->fromOrderingToData($ordering);
            }

            if ($criteria->hasUuids()) {
                $uuids = $criteria->getUuids();
                $uuidStrings = $uuidAdapter->fromUuidsToHumanReadableStrings($uuids);
                if (!empty($orderingData)) {
                    return [
                        'uuids' => $uuidStrings,
                        'ordering' => $orderingData
                    ];
                }

                return [
                    'uuids' => $uuidStrings
                ];
            }

            if (!empty($orderingData)) {
                return [
                    'ordering' => $orderingData
                ];
            }

            return [];
        };

        $createURI = function() use(&$criteria) {

            $container = $criteria->getContainerName();
            $uri = '/'.$container;

            if ($criteria->hasKeyname()) {
                $keyname = $criteria->getKeyname();
                $name = $keyname->getName();
                $value = $keyname->getValue();
                return $uri.'/'.$name.'/'.$value;
            }

            return $uri;
        };

        try {

            $uri = $createURI();
            $params = $createRequestParams();

            return [
                'uri' => $uri,
                'query_parameters' => $params,
                'method' => 'get',
                'port' => $this->port,
                'headers' => $this->headers
            ];

        } catch (UuidException $exception) {
            throw new RequestSetException('There was an exception while converting Uuid objects to uuids.', $exception);
        } catch (OrderingException $exception) {
            throw new RequestSetException('There was an exception while converting an Ordering object to data.', $exception);
        }

    }

}
