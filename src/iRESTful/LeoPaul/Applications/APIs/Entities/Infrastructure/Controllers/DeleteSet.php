<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Factories\EntitySetRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\Factories\EntitySetServiceFactory;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidRequestException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Exceptions\ControllerResponseException;

class DeleteSet implements Controller {
    private $responseAdapter;
    private $entitySetRepositoryFactory;
    private $entitySetServiceFactory;
    private $adapterFactory;
    private $deleteFilePath;
    public function __construct(
        ControllerResponseAdapter $responseAdapter,
        EntitySetRepositoryFactory $entitySetRepositoryFactory,
        EntitySetServiceFactory $entitySetServiceFactory,
        EntityAdapterFactory $adapterFactory,
        $deleteFilePath = 'php://input'
    ) {
        $this->responseAdapter = $responseAdapter;
        $this->entitySetRepositoryFactory = $entitySetRepositoryFactory;
        $this->entitySetServiceFactory = $entitySetServiceFactory;
        $this->adapterFactory = $adapterFactory;
        $this->deleteFilePath = $deleteFilePath;
    }

    public function execute(HttpRequest $request) {

        $create = function(array $input) {
            $firstPass = [];
            foreach($input as $oneInput) {

                if (!isset($oneInput['container'])) {
                    throw new InvalidRequestException('Each element of the input must contain a container keyname.');
                }

                if (!isset($oneInput['uuid'])) {
                    throw new InvalidRequestException('Each element of the input must contain a uuid keyname.');
                }

                $firstPass[$oneInput['container']][] = $oneInput['uuid'];
            }

            $output = [];
            $containers = array_keys($firstPass);
            foreach($containers as $index => $containerName) {
                $output[] = [
                    'container' => $containerName,
                    'uuids' => $firstPass[$containerName]
                ];
            }

            return $output;
        };

        $input = [];
        if ($request->hasParameters()) {
            $input = $request->getParameters();
        }

        //retrieve the put data:
        $deleteData = [];
        parse_str(file_get_contents($this->deleteFilePath), $deleteData);
        $input = array_merge($input, $deleteData);

        try {

            $entities = [];
            $criterias = $create($input);
            $repositorySet = $this->entitySetRepositoryFactory->create();
            foreach($criterias as $oneCriteria) {
                $batch = $repositorySet->retrieve($oneCriteria);
                $entities = array_merge($entities, $batch);
            }

            $serviceSet = $this->entitySetServiceFactory->create();
            $serviceSet->delete($entities);

            $adapter = $this->adapterFactory->create();
            $output = $adapter->fromEntitiesToData($entities, true);
            return $this->responseAdapter->fromDataToControllerResponse($output);

        } catch (EntityException $exception) {
            throw new ServerException('There was an exception while retrieving/deleting Entity objects and/or converting entity objects to human readable data and/or creating a repositorySet/serviceSet/adapter using a factory.', $exception);
        } catch (ControllerResponseException $exception) {
            throw new ServerException('There was an exception while converting data to a ControllerResponse object.', $exception);
        }
    }
}
