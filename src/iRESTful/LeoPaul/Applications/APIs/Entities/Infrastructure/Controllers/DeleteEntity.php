<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Factories\EntityRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\Factories\EntityServiceFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidRequestException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\NotFoundException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Exceptions\ControllerResponseException;

class DeleteEntity implements Controller {
    private $responseAdapter;
    private $repositoryFactory;
    private $serviceFactory;
    private $adapterFactory;
    public function __construct(
        ControllerResponseAdapter $responseAdapter,
        EntityRepositoryFactory $repositoryFactory,
        EntityServiceFactory $serviceFactory,
        EntityAdapterFactory $adapterFactory
    ) {
        $this->responseAdapter = $responseAdapter;
        $this->repositoryFactory = $repositoryFactory;
        $this->serviceFactory = $serviceFactory;
        $this->adapterFactory = $adapterFactory;
    }

    public function execute(HttpRequest $request) {

        $input = [];
        if ($request->hasParameters()) {
            $input = $request->getParameters();
        }

        if (!isset($input['uuid'])) {
            throw new InvalidRequestException('The uuid is mandatory to delete an Entity object.');
        }

        if (!isset($input['container'])) {
            throw new InvalidRequestException('The container is mandatory to delete an Entity object.');
        }

        try {

            $repository = $this->repositoryFactory->create();
            $entity = $repository->retrieve([
                'container' => $input['container'],
                'uuid' => $input['uuid']
            ]);

            if (empty($entity)) {
                throw new NotFoundException('The given uuid ('.$input['uuid'].') does not point to a valid Entity object.');
            }

            $service = $this->serviceFactory->create();
            $service->delete($entity);

            $adapter = $this->adapterFactory->create();
            $output = $adapter->fromEntityToData($entity, true);
            return $this->responseAdapter->fromDataToControllerResponse($output);

        } catch (EntityException $exception) {
            throw new ServerException('There was an exception while retrieving/deleting an Entity and/or converting an entity to human readable data and/or creating a repository/service/adapter using a factory.', $exception);
        } catch (ControllerResponseException $exception) {
            throw new ServerException('There was an exception while converting data to a ControllerResponse object.', $exception);
        }
    }
}
