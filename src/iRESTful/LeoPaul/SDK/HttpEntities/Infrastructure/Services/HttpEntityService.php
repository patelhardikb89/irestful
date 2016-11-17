<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Services;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\EntityService;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
use iRESTful\LeoPaul\Objects\Libraries\Https\Applications\HttpApplication;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class HttpEntityService implements EntityService {
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

    public function insert(Entity $entity) {

        try {

            $entityAdapter = $this->entityAdapterFactory->create();
            $data = $entityAdapter->fromEntityToData($entity, true);
            $containerName = $entityAdapter->fromEntityToContainerName($entity);

            $uri = '/'.$containerName;
            $response = $this->httpApplication->execute([
                'uri' => $uri,
                'request_parameters' => $data,
                'method' => 'post',
                'port' => $this->port,
                'headers' => $this->headers
            ]);

            if ($response->getCode() != 200) {
                throw new EntityException($response->getContent());
            }

        } catch (HttpException $exception) {
            throw new EntityException('There was an exception while executing an HttpRequest.', $exception);
        }

    }

    public function update(Entity $originalEntity, Entity $updatedEntity) {

        try {

            $entityAdapter = $this->entityAdapterFactory->create();
            $data = $entityAdapter->fromEntityToData($updatedEntity, true);
            $containerName = $entityAdapter->fromEntityToContainerName($updatedEntity);
            $uuid = $originalEntity->getUuid()->getHumanReadable();

            $uri = '/'.$containerName.'/'.$uuid;
            $response = $this->httpApplication->execute([
                'uri' => $uri,
                'request_parameters' => $data,
                'method' => 'put',
                'port' => $this->port,
                'headers' => $this->headers
            ]);

            if ($response->getCode() != 200) {
                throw new EntityException($response->getContent());
            }

        } catch (HttpException $exception) {
            throw new EntityException('There was an exception while executing an HttpRequest.', $exception);
        }

    }

    public function delete(Entity $entity) {

        try {

            $entityAdapter = $this->entityAdapterFactory->create();
            $containerName = $entityAdapter->fromEntityToContainerName($entity);

            $uuid = $entity->getUuid()->getHumanReadable();
            $uri = '/'.$containerName.'/'.$uuid;
            $response = $this->httpApplication->execute([
                'uri' => $uri,
                'method' => 'delete',
                'port' => $this->port,
                'headers' => $this->headers
            ]);

            if ($response->getCode() != 200) {
                throw new EntityException($response->getContent());
            }

        } catch (HttpException $exception) {
            throw new EntityException('There was an exception while executing an HttpRequest.', $exception);
        }
    }

}
