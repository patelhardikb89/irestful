<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\Factories\EntitySetServiceFactory;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidRequestException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Exceptions\ControllerResponseException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Factories\EntitySetRepositoryFactory;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\Factories\ObjectAdapterFactory;

final class UpdateSet implements Controller {
    private $responseAdapter;
    private $repositorySetFactory;
    private $serviceSetFactory;
    private $adapterFactory;
    private $objectAdapterFactory;
    private $putFilePath;
    public function __construct(
        ControllerResponseAdapter $responseAdapter,
        EntitySetRepositoryFactory $repositorySetFactory,
        EntitySetServiceFactory $serviceSetFactory,
        EntityAdapterFactory $adapterFactory,
        ObjectAdapterFactory $objectAdapterFactory,
        $putFilePath = 'php://input'
    ) {
        $this->responseAdapter = $responseAdapter;
        $this->repositorySetFactory = $repositorySetFactory;
        $this->serviceSetFactory = $serviceSetFactory;
        $this->adapterFactory = $adapterFactory;
        $this->objectAdapterFactory = $objectAdapterFactory;
        $this->putFilePath = $putFilePath;
    }

    public function execute(HttpRequest $request) {

        $create = function(array $input) {
            $firstPass = [];
            $updatedFirstPass = [];
            foreach($input as $oneInput) {

                if (!isset($oneInput['container'])) {
                    throw new InvalidRequestException('Each element of the input must contain a container keyname.');
                }

                if (!isset($oneInput['uuid'])) {
                    throw new InvalidRequestException('Each element of the input must contain a uuid keyname.');
                }

                $containerName = $oneInput['container'];
                $firstPass[$containerName][] = $oneInput['uuid'];
                $updatedFirstPass[$containerName][] = [
                    'container' => $containerName,
                    'data' => $oneInput['updated_entity']
                ];
            }

            $output = [];
            $containers = array_keys($firstPass);
            foreach($containers as $index => $containerName) {
                $output[] = [
                    'container' => $containerName,
                    'uuids' => $firstPass[$containerName],
                    'updated_entities' => $updatedFirstPass[$containerName]
                ];
            }

            return $output;
        };

        $input = [];
        if ($request->hasParameters()) {
            $input = $request->getParameters();
        }

        //retrieve the put data:
        $putData = [];
        parse_str(file_get_contents($this->putFilePath), $putData);
        $input = array_merge($input, $putData);

        try {

            $originalEntities = [];
            $updatedEntities = [];
            $criterias = $create($input);

            $objectAdapter = $this->objectAdapterFactory->create();
            $repositorySet = $this->repositorySetFactory->create();

            foreach($criterias as $oneCriteria) {

                $updatedBatch = $objectAdapter->fromDataToObjects($oneCriteria['updated_entities']);
                $updatedEntities = array_merge($updatedEntities, $updatedBatch);

                $originalBatch = $repositorySet->retrieve($oneCriteria);
                $originalEntities = array_merge($originalEntities, $originalBatch);
            }

            $serviceSet = $this->serviceSetFactory->create();
            $serviceSet->update($originalEntities, $updatedEntities);

            $adapter = $this->adapterFactory->create();
            $output = $adapter->fromEntitiesToData($updatedEntities, true);
            return $this->responseAdapter->fromDataToControllerResponse($output);

        } catch (EntityException $exception) {
            throw new ServerException('There was an exception while retrieving/deleting Entity objects and/or converting entity objects to human readable data and/or creating a repositorySet/serviceSet/adapter using a factory.', $exception);
        } catch (ControllerResponseException $exception) {
            throw new ServerException('There was an exception while converting data to a ControllerResponse object.', $exception);
        }
    }

}
