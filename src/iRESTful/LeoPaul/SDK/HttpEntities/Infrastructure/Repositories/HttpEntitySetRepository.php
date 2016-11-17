<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\EntitySetRepository;
use iRESTful\LeoPaul\Objects\Libraries\Https\Applications\HttpApplication;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Sets\Adapters\RequestSetAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Responses\Adapters\ResponseAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Responses\Exceptions\ResponseException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Sets\Exceptions\RequestSetException;

final class HttpEntitySetRepository implements EntitySetRepository {
    private $httpApplication;
    private $requestSetAdapter;
    private $responseAdapter;
    private $entityAdapterFactory;
    public function __construct(
        HttpApplication $httpApplication,
        RequestSetAdapter $requestSetAdapter,
        ResponseAdapter $responseAdapter,
        EntityAdapterFactory $entityAdapterFactory
    ) {
        $this->httpApplication = $httpApplication;
        $this->requestSetAdapter = $requestSetAdapter;
        $this->responseAdapter = $responseAdapter;
        $this->entityAdapterFactory = $entityAdapterFactory;
    }

    public function retrieve(array $criteria) {

        if (!isset($criteria['container'])) {
            throw new EntitySetException('The container is mandatory in the criteria in order to retrieve Entity objects.');
        }

        try {

            $httpRequest = $this->requestSetAdapter->fromDataToEntitySetHttpRequestData($criteria);
            $httpResponse = $this->httpApplication->execute($httpRequest);
            $data = $this->responseAdapter->fromHttpResponseToData($httpResponse);
            if (empty($data)) {
                return [];
            }

            $output = [];
            foreach($data as $index => $oneData) {
                $output[] = [
                    'container' => $criteria['container'],
                    'data' => $oneData
                ];
            }

            $entityAdapter = $this->entityAdapterFactory->create();
            return $entityAdapter->fromDataToEntities($output);

        } catch (RequestSetException $exception) {
            throw new EntitySetException('There was an exception while converting data to an HttpRequest object.', $exception);
        } catch (HttpException $exception) {
            throw new EntitySetException('There was an exception while executing an HttpRequest.', $exception);
        } catch (ResponseException $exception) {
            throw new EntitySetException('There was an exception while converting an HttpResponse to entities data.', $exception);
        } catch (EntityException $exception) {
            throw new EntitySetException('There was an exception while converting data to Entity objects.', $exception);
        }

    }

}
