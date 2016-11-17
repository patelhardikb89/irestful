<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\EntityPartialSetRepository;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Sets\Partials\Adapters\RequestPartialSetAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Applications\HttpApplication;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Responses\Adapters\ResponseAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\EntityPartialSetAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Responses\Exceptions\ResponseException;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Sets\Partials\Exceptions\RequestPartialSetException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class HttpEntityPartialSetRepository implements EntityPartialSetRepository {
    private $httpApplication;
    private $requestPartialSetAdapter;
    private $responseAdapter;
    private $entityPartialSetAdapter;
    public function __construct(
        HttpApplication $httpApplication,
        RequestPartialSetAdapter $requestPartialSetAdapter,
        ResponseAdapter $responseAdapter,
        EntityPartialSetAdapter $entityPartialSetAdapter
    ) {
        $this->httpApplication = $httpApplication;
        $this->requestPartialSetAdapter = $requestPartialSetAdapter;
        $this->responseAdapter = $responseAdapter;
        $this->entityPartialSetAdapter = $entityPartialSetAdapter;
    }

    public function retrieve(array $criteria) {

        if (!isset($criteria['container'])) {
            throw new EntityPartialSetException('The container is mandatory in the criteria in order to retrieve an EntityPartialSet object.');
        }

        try {

            $httpRequest = $this->requestPartialSetAdapter->fromDataToEntityPartialSetHttpRequestData($criteria);
            $httpResponse = $this->httpApplication->execute($httpRequest);
            $data = $this->responseAdapter->fromHttpResponseToData($httpResponse);

            if (empty($data)) {
                throw new EntityPartialSetException('The data is null, therefore there was a problem while retrieving the EntityPartialSet object.');
            }

            if (isset($data['entities']) || !empty($data['entities'])) {
                $entities = [];
                foreach($data['entities'] as $index => $oneEntity) {
                    $entities[] = [
                        'container' => $criteria['container'],
                        'data' => $oneEntity
                    ];
                }

                $data['entities'] = $entities;
            }

            return $this->entityPartialSetAdapter->fromDataToEntityPartialSet($data);

        } catch (RequestPartialSetException $exception) {
            throw new EntityPartialSetException('There was an exception while converting data to an HttpRequest object.', $exception);
        } catch (HttpException $exception) {
            throw new EntityPartialSetException('There was an exception while executing an HttpRequest.', $exception);
        } catch (ResponseException $exception) {
            throw new EntityPartialSetException('There was an exception while converting an HttpResponse to entities data.', $exception);
        }

    }

}
