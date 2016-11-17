<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Relations\Adapters\RequestRelationAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Responses\Adapters\ResponseAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Applications\HttpApplication;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Relations\Exceptions\RequestRelationException;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Responses\Exceptions\ResponseException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;

final class HttpEntityRelationRepository implements EntityRelationRepository {
    private $httpApplication;
    private $requestRelationAdapter;
    private $responseAdapter;
    private $entityAdapterFactory;
    public function __construct(
        HttpApplication $httpApplication,
        RequestRelationAdapter $requestRelationAdapter,
        ResponseAdapter $responseAdapter
    ) {
        $this->httpApplication = $httpApplication;
        $this->requestRelationAdapter = $requestRelationAdapter;
        $this->responseAdapter = $responseAdapter;
        $this->entityAdapterFactory = null;
    }

    public function addEntityAdapterFactory(EntityAdapterFactory $entityAdapterFactory) {
        $this->entityAdapterFactory = $entityAdapterFactory;
        return $this;
    }

    public function retrieve(array $criteria) {

        if (!isset($criteria['slave_container'])) {
            throw new EntityRelationException('The slave_container keyname is mandatory in order to retrieve related Entity objects.');
        }

        if (empty($this->entityAdapterFactory)) {
            throw new EntityRelationException('The EntityAdapterFactory object must be added before using this repository.');
        }

        try {

            $httpRequest = $this->requestRelationAdapter->fromDataToEntityRelationHttpRequestData($criteria);
            $httpResponse = $this->httpApplication->execute($httpRequest);
            $data = $this->responseAdapter->fromHttpResponseToData($httpResponse);
            if (empty($data)) {
                return [];
            }

            $output = [];
            foreach($data as $index => $oneData) {
                $output[] = [
                    'container' => $criteria['slave_container'],
                    'data' => $oneData
                ];
            }

            $entityAdapter = $this->entityAdapterFactory->create();
            return $entityAdapter->fromDataToEntities($output);

        } catch (RequestRelationException $exception) {
            throw new EntityRelationException('There was an exception while converting sata to an HttpRequest.', $exception);
        } catch (HttpException $exception) {
            throw new EntityRelationException('There was an exception while executing an HttpRequest.', $exception);
        } catch (ResponseException $exception) {
            throw new EntityRelationException('There was an exception while converting an HttpResponse to entities data.', $exception);
        } catch (EntityException $exception) {
            throw new EntityRelationException('There was an exception while converting data to Entity objects.', $exception);
        }
    }

}
