<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidRequestException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Exceptions\ControllerResponseException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Services\Service;

class InsertSet implements Controller {
    private $responseAdapter;
    private $service;
    private $adapter;
    public function __construct(ControllerResponseAdapter $responseAdapter, Service $service) {
        $this->responseAdapter = $responseAdapter;
        $this->service = $service->getService()->getEntitySet();
        $this->adapter = $service->getAdapter()->getEntity();
    }

    public function execute(HttpRequest $request) {

        $input = [];
        if ($request->hasParameters()) {
            $input = $request->getParameters();
        }

        try {

            $entities = $this->adapter->fromDataToEntities($input);
            $this->service->insert($entities);
            $output = $this->adapter->fromEntitiesToData($entities, true);
            return $this->responseAdapter->fromDataToControllerResponse($output);

        } catch (EntityException $exception) {
            throw new ServerException('There was an exception while converting data to an Entity object and/or when converting entities to human readable data.', $exception);
        } catch (EntitySetException $exception) {
            throw new ServerException('There was an exception while inserting Entity objects.', $exception);
        } catch (ControllerResponseException $exception) {
            throw new ServerException('There was an exception while converting data to a ControllerResponse object.', $exception);
        }
    }
}
