<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidRequestException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\NotFoundException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Exceptions\ObjectException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Exceptions\ControllerResponseException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Services\Service;

class UpdateEntity implements Controller {
    private $responseAdapter;
    private $repository;
    private $service;
    private $adapter;
    private $objectAdapter;
    private $putFilePath;
    public function __construct(ControllerResponseAdapter $responseAdapter, Service $service, $putFilePath = 'php://input') {
        $this->responseAdapter = $responseAdapter;
        $this->repository = $service->getRepository()->getEntity();
        $this->service = $service->getService()->getEntity();
        $this->adapter = $service->getAdapter()->getEntity();
        $this->objectAdapter = $service->getAdapter()->getObject();
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

            $originalEntity = $this->repository->retrieve([
                'container' => $input['container'],
                'uuid' => $input['original_uuid']
            ]);

            //retrieve the put data:
            $putData = [];
            parse_str(file_get_contents($this->putFilePath), $putData);

            //updated entity:
            $updatedEntity = $this->objectAdapter->fromDataToObject([
                'container' => $input['container'],
                'data' => $putData
            ]);

            $this->service->update($originalEntity, $updatedEntity);
            $output = $this->adapter->fromEntityToData($updatedEntity, true);
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
