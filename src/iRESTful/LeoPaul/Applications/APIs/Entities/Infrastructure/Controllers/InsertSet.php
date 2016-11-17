<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\Factories\EntitySetServiceFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidRequestException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Exceptions\ControllerResponseException;

class InsertSet implements Controller {
    private $responseAdapter;
    private $serviceFactory;
    private $adapterFactory;
    public function __construct(
        ControllerResponseAdapter $responseAdapter,
        EntitySetServiceFactory $serviceFactory,
        EntityAdapterFactory $adapterFactory
    ) {
        $this->responseAdapter = $responseAdapter;
        $this->serviceFactory = $serviceFactory;
        $this->adapterFactory = $adapterFactory;
    }

    public function execute(HttpRequest $request) {

        $input = [];
        if ($request->hasParameters()) {
            $input = $request->getParameters();
        }

        try {

            $adapter = $this->adapterFactory->create();
            $entities = $adapter->fromDataToEntities($input);

            $service = $this->serviceFactory->create();
            $service->insert($entities);

            $output = $adapter->fromEntitiesToData($entities, true);
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
