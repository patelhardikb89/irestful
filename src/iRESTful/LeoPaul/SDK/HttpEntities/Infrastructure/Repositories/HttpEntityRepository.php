<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Adapters\RequestAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Applications\HttpApplication;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Adapters\EntityAdapterAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Exceptions\RequestException;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Responses\Adapters\ResponseAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Responses\Exceptions\ResponseException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository;

final class HttpEntityRepository implements EntityRepository {
    private $httpApplication;
    private $requestAdapter;
    private $responseAdapter;
    private $entityAdapterAdapter;
    public function __construct(
        HttpApplication $httpApplication,
        RequestAdapter $requestAdapter,
        ResponseAdapter $responseAdapter,
        EntityAdapterAdapter $entityAdapterAdapter
    ) {
        $this->httpApplication = $httpApplication;
        $this->requestAdapter = $requestAdapter;
        $this->responseAdapter = $responseAdapter;
        $this->entityAdapterAdapter = $entityAdapterAdapter;
        $this->entityRelationRepository = null;
    }

    public function addEntityRelationRepository(EntityRelationRepository $entityRelationRepository) {
        $this->entityRelationRepository = $entityRelationRepository;
        return $this;
    }

    public function exists(array $criteria) {
        $entity = $this->retrieve($criteria);
        return !empty($entity);
    }

    public function retrieve(array $criteria) {

        if (!isset($criteria['container'])) {
            throw new EntityException('The container is mandatory in the criteria in order to retrieve an Entity.');
        }

        if (empty($this->entityRelationRepository)) {
            throw new EntityException('The EntityRelationRepository object must be added before using this repository.');
        }

        try {

            $httpRequest = $this->requestAdapter->fromDataToEntityHttpRequestData($criteria);
            $response = $this->httpApplication->execute($httpRequest);
            $data = $this->responseAdapter->fromHttpResponseToData($response);
            if (empty($data)) {
                return null;
            }

            $entityAdapter = $this->entityAdapterAdapter->fromRepositoriesToEntityAdapter($this, $this->entityRelationRepository);
            return $entityAdapter->fromDataToEntity([
                'container' => $criteria['container'],
                'data' => $data
            ]);

        } catch (RequestException $exception) {
            throw new EntityException('There was an exception while converting data to an HttpRequest.', $exception);
        } catch (HttpException $exception) {
            throw new EntityException('There was an exception while executing an HttpRequest.', $exception);
        } catch (ResponseException $exception) {
            throw new EntityException('There was an exception while converting an HttpResponse to entity data.', $exception);
        }
    }
}
