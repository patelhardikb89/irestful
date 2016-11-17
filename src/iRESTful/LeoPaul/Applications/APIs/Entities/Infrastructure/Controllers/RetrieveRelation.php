<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Factories\EntityRelationRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidRequestException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Exceptions\ControllerResponseException;

class RetrieveRelation implements Controller {
    private $responseAdapter;
    private $repositoryFactory;
    private $adapterFactory;
    public function __construct(
        ControllerResponseAdapter $responseAdapter,
        EntityRelationRepositoryFactory $repositoryFactory,
        EntityAdapterFactory $adapterFactory
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

        if (!isset($input['master_container'])) {
            throw new InvalidRequestException('The master_container param is mandatory.');
        }

        if (!isset($input['slave_container'])) {
            throw new InvalidRequestException('The slave_container param is mandatory.');
        }

        if (!isset($input['slave_property'])) {
            throw new InvalidRequestException('The slave_property param is mandatory.');
        }

        if (!isset($input['master_uuid'])) {
            throw new InvalidRequestException('The master_uuid param is mandatory.');
        }

        try {

            $repository = $this->repositoryFactory->create();
            $entities = $repository->retrieve([
                'master_container' => $input['master_container'],
                'slave_container' => $input['slave_container'],
                'slave_property' => $input['slave_property'],
                'master_uuid' => $input['master_uuid']
            ]);

            $adapter = $this->adapterFactory->create();
            $output = $adapter->fromEntitiesToData($entities, true);
            return $this->responseAdapter->fromDataToControllerResponse($output);

        } catch (EntityException $exception) {
            throw new ServerException('There was an exception while converting entities to human readable data.', $exception);
        } catch (EntityRelationException $exception) {
            throw new ServerException('There was an exception while retrieving Entity objects.', $exception);
        } catch (ControllerResponseException $exception) {
            throw new ServerException('There was an exception while converting data to a ControllerResponse object.', $exception);
        }
    }

}
