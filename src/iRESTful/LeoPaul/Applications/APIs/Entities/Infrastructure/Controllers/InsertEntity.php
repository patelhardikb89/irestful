<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\Factories\EntityServiceFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidRequestException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Exceptions\ControllerResponseException;

class InsertEntity implements Controller {
    private $responseAdapter;
    private $serviceFactory;
    private $adapterFactory;
    public function __construct(
        ControllerResponseAdapter $responseAdapter,
        EntityServiceFactory $serviceFactory,
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

        if (!isset($input['container'])) {
            throw new InvalidRequestException('The container is mandatory to insert an Entity object.');
        }

        try {

            $adapter = $this->adapterFactory->create();

            $container = $input['container'];
            unset($input['container']);
            $data = [
                'container' => $container,
                'data' => $input
            ];

            $entity = $adapter->fromDataToEntity($data);

            $service = $this->serviceFactory->create();
            $service->insert($entity);

            $output = $adapter->fromEntityToData($entity, true);
            return $this->responseAdapter->fromDataToControllerResponse($output);

        } catch (EntityException $exception) {
            throw new ServerException('There was an exception while converting and/or inserting an Entity object.', $exception);
        } catch (ControllerResponseException $exception) {
            throw new ServerException('There was an exception while converting data to a ControllerResponse object.', $exception);
        }
    }
}
