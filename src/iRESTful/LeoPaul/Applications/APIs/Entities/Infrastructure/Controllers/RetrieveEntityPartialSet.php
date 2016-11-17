<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Factories\EntityPartialSetRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\Factories\EntityPartialSetAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidRequestException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\NotFoundException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Exceptions\ControllerResponseException;

class RetrieveEntityPartialSet implements Controller {
    private $responseAdapter;
    private $repositoryFactory;
    private $adapterFactory;
    public function __construct(
        ControllerResponseAdapter $responseAdapter,
        EntityPartialSetRepositoryFactory $repositoryFactory,
        EntityPartialSetAdapterFactory $adapterFactory
    ) {
        $this->responseAdapter = $responseAdapter;
        $this->repositoryFactory = $repositoryFactory;
        $this->adapterFactory = $adapterFactory;
    }

    public function execute(HttpRequest $request) {

        $input = [];
        if ($request->hasParameters()) {
            $input = $request->getParameters();
        }

        if (!isset($input['container'])) {
            throw new InvalidRequestException('The container param is mandatory.');
        }

        if (!isset($input['index'])) {
            throw new InvalidRequestException('The index param is mandatory.');
        }

        if (!isset($input['amount'])) {
            throw new InvalidRequestException('The amount param is mandatory.');
        }

        try {

            $params = [
                'container' => $input['container'],
                'index' => $input['index'],
                'amount' => $input['amount']
            ];

            if (isset($input['ordering'])) {
                $params['ordering'] = $input['ordering'];
            }

            $repository = $this->repositoryFactory->create();
            $entityPartialSet = $repository->retrieve($params);

            $adapter = $this->adapterFactory->create();
            $output = $adapter->fromEntityPartialSetToData($entityPartialSet);
            return $this->responseAdapter->fromDataToControllerResponse($output);

        } catch (EntityPartialSetException $exception) {
            throw new ServerException('There was an exception while retrieving an EntityPartialset object and/or when converting an EntityPartialSet object to human readable data.', $exception);
        } catch (ControllerResponseException $exception) {
            throw new ServerException('There was an exception while converting data to a ControllerResponse object.', $exception);
        }
    }
}
