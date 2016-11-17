<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Services;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\EntitySetService;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
use iRESTful\LeoPaul\Objects\Libraries\Https\Applications\HttpApplication;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class HttpEntitySetService implements EntitySetService {
    private $entityAdapterFactory;
    private $httpApplication;
    private $port;
    private $headers;
    public function __construct(
        EntityAdapterFactory $entityAdapterFactory,
        HttpApplication $httpApplication,
        $port = 80,
        array $headers = null
    ) {
        $this->entityAdapterFactory = $entityAdapterFactory;
        $this->httpApplication = $httpApplication;
        $this->port = $port;
        $this->headers = $headers;
    }

    public function insert(array $entities) {
        try {

            $entityAdapter = $this->entityAdapterFactory->create();
            $data = $entityAdapter->fromEntitiesToData($entities, false);

            $requestParameters = [];
            foreach($entities as $index => $oneEntity) {
                $containerName = $entityAdapter->fromEntityToContainerName($oneEntity);
                $requestParameters[] = [
                    'container' => $containerName,
                    'data' => $data[$index]
                ];
            }

            $response = $this->httpApplication->execute([
                'uri' => '/',
                'request_parameters' => $requestParameters,
                'method' => 'post',
                'port' => $this->port,
                'headers' => $this->headers
            ]);

            if ($response->getCode() != 200) {
                throw new EntitySetException($response->getContent());
            }

        } catch (EntityException $exception) {
            throw new EntitySetException('There was an exception while converting Entity objects to data and/or containerName.', $exception);
        } catch (HttpException $exception) {
            throw new EntitySetException('There was an exception while executing an HttpRequest.', $exception);
        }
    }

    public function update(array $originalEntities, array $updatedEntities) {

        try {

            $requestParameters = [];
            $entityAdapter = $this->entityAdapterFactory->create();
            foreach($originalEntities as $index => $oneOriginalEntity) {

                $uuid = $oneOriginalEntity->getUuid()->getHumanReadable();
                $containerName = $entityAdapter->fromEntityToContainerName($oneOriginalEntity);
                $updatedEntity = $entityAdapter->fromEntityToData($updatedEntities[$index], true);

                $requestParameters[] = [
                    'uuid' => $uuid,
                    'container' => $containerName,
                    'updated_entity' => $updatedEntity
                ];
            }

            $response = $this->httpApplication->execute([
                'uri' => '/',
                'request_parameters' => $requestParameters,
                'method' => 'put',
                'port' => $this->port,
                'headers' => $this->headers
            ]);

            if ($response->getCode() != 200) {
                throw new EntitySetException($response->getContent());
            }

        } catch (EntityException $exception) {
            throw new EntitySetException('There was an exception while converting Entity objects to data and/or containerName.', $exception);
        } catch (HttpException $exception) {
            throw new EntitySetException('There was an exception while executing an HttpRequest.', $exception);
        }
    }

    public function delete(array $entities) {

        try {

            $requestParameters = [];
            $entityAdapter = $this->entityAdapterFactory->create();
            foreach($entities as $oneEntity) {
                $containerName = $entityAdapter->fromEntityToContainerName($oneEntity);
                $requestParameters[] = [
                    'container' => $containerName,
                    'uuid' => $oneEntity->getUuid()->getHumanReadable()
                ];
            }

            $response = $this->httpApplication->execute([
                'uri' => '/',
                'request_parameters' => $requestParameters,
                'method' => 'delete',
                'port' => $this->port,
                'headers' => $this->headers
            ]);

            if ($response->getCode() != 200) {
                throw new EntitySetException($response->getContent());
            }

        } catch (EntityException $exception) {
            throw new EntitySetException('There was an exception while converting an Entity object to a containerName.', $exception);
        } catch (HttpException $exception) {
            throw new EntitySetException('There was an exception while executing an HttpRequest.', $exception);
        }
    }

    private function getUuids(array $entities) {
        $output = [];
        foreach($entities as $oneEntity) {
            $output[] = $oneEntity->getUuid()->getHumanReadable();
        }

        return $output;
    }

}
