<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidRequestException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\NotFoundException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Exceptions\ControllerResponseException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Services\Service;

class DeleteEntity implements Controller {
    private $responseAdapter;
    private $repository;
    private $service;
    private $adapter;
    public function __construct(ControllerResponseAdapter $responseAdapter, Service $service) {
        $this->responseAdapter = $responseAdapter;
        $this->repository = $service->getRepository()->getEntity();
        $this->service = $service->getService()->getEntity();
        $this->adapter = $service->getAdapter()->getEntity();
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

            $entity = $this->repository->retrieve([
                'container' => $input['container'],
                'uuid' => $input['uuid']
            ]);

            if (empty($entity)) {
                throw new NotFoundException('The given uuid ('.$input['uuid'].') does not point to a valid Entity object.');
            }

            $this->service->delete($entity);
            $output = $this->adapter->fromEntityToData($entity, true);
            return $this->responseAdapter->fromDataToControllerResponse($output);

        } catch (EntityException $exception) {
            throw new ServerException('There was an exception while retrieving/deleting an Entity and/or converting an entity to human readable data.', $exception);
        } catch (ControllerResponseException $exception) {
            throw new ServerException('There was an exception while converting data to a ControllerResponse object.', $exception);
        }
    }
}
