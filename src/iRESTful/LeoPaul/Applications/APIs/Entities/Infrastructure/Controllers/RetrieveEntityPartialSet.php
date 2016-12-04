<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidRequestException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\NotFoundException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Exceptions\ControllerResponseException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Services\Service;

class RetrieveEntityPartialSet implements Controller {
    private $responseAdapter;
    private $repository;
    private $adapter;
    public function __construct(ControllerResponseAdapter $responseAdapter, Service $service) {
        $this->responseAdapter = $responseAdapter;
        $this->repository = $service->getRepository()->getEntityPartialSet();
        $this->adapter = $service->getAdapter()->getEntityPartialSet();
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

            $entityPartialSet = $this->repository->retrieve($params);
            $output = $this->adapter->fromEntityPartialSetToData($entityPartialSet);
            return $this->responseAdapter->fromDataToControllerResponse($output);

        } catch (EntityPartialSetException $exception) {
            throw new ServerException('There was an exception while retrieving an EntityPartialset object and/or when converting an EntityPartialSet object to human readable data.', $exception);
        } catch (ControllerResponseException $exception) {
            throw new ServerException('There was an exception while converting data to a ControllerResponse object.', $exception);
        }
    }
}
