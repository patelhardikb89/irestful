<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Factories\EntityRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\Factories\EntityServiceFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidRequestException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\NotFoundException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\Factories\ObjectAdapterFactory;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Exceptions\ObjectException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Exceptions\ControllerResponseException;

class UpdateEntity implements Controller {
    private $responseAdapter;
    private $repositoryFactory;
    private $serviceFactory;
    private $adapterFactory;
    private $objectAdapterFactory;
    private $putFilePath;
    public function __construct(
        ControllerResponseAdapter $responseAdapter,
        EntityRepositoryFactory $repositoryFactory,
        EntityServiceFactory $serviceFactory,
        EntityAdapterFactory $adapterFactory,
        ObjectAdapterFactory $objectAdapterFactory,
        $putFilePath = 'php://input'
    ) {
        $this->responseAdapter = $responseAdapter;
        $this->repositoryFactory = $repositoryFactory;
        $this->serviceFactory = $serviceFactory;
        $this->adapterFactory = $adapterFactory;
        $this->objectAdapterFactory = $objectAdapterFactory;
        $this->putFilePath = $putFilePath;
    }

    public function execute(HttpRequest $request) {

        $input = [];
        if ($request->hasParameters()) {
            $input = $request->getParameters();
        }

        if (!isset($input['container'])) {
            throw new InvalidRequestException('The container param is mandatory.');
        }

        if (!isset($input['original_uuid'])) {
            throw new InvalidRequestException('The original_uuid param is mandatory.');
        }

        try {

            $repository = $this->repositoryFactory->create();
            $originalEntity = $repository->retrieve([
                'container' => $input['container'],
                'uuid' => $input['original_uuid']
            ]);

            //retrieve the put data:
            $putData = [];
            parse_str(file_get_contents($this->putFilePath), $putData);

            //updated entity:
            $objectAdapter = $this->objectAdapterFactory->create();
            $updatedEntity = $objectAdapter->fromDataToObject([
                'container' => $input['container'],
                'data' => $putData
            ]);

            $service = $this->serviceFactory->create();
            $service->update($originalEntity, $updatedEntity);

            $adapter = $this->adapterFactory->create();
            $output = $adapter->fromEntityToData($updatedEntity, true);
            return $this->responseAdapter->fromDataToControllerResponse($output);

        } catch (ObjectException $exception) {
            throw new ServerException('There was an exception while converting data to an Object.', $exception);
        } catch (EntityException $exception) {
            throw new ServerException('There was an exception while retrieving, converting and/or updating an Entity object.', $exception);
        } catch (ControllerResponseException $exception) {
            throw new ServerException('There was an exception while converting data to a ControllerResponse object.', $exception);
        }
    }
}
