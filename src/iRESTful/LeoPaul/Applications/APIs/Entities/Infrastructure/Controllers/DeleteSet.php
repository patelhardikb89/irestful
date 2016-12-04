<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidRequestException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Exceptions\ControllerResponseException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Services\Service;

class DeleteSet implements Controller {
    private $responseAdapter;
    private $entitySetRepository;
    private $entitySetService;
    private $adapter;
    private $deleteFilePath;
    public function __construct(ControllerResponseAdapter $responseAdapter, Service $service, $deleteFilePath = 'php://input') {
        $this->responseAdapter = $responseAdapter;
        $this->entitySetRepository = $service->getRepository()->getEntitySet();
        $this->entitySetService = $service->getService()->getEntitySet();
        $this->adapter = $service->getAdapter()->getEntity();
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
            foreach($criterias as $oneCriteria) {
                $batch = $this->entitySetRepository->retrieve($oneCriteria);
                $entities = array_merge($entities, $batch);
            }

            $this->entitySetService->delete($entities);
            $output = $this->adapter->fromEntitiesToData($entities, true);
            return $this->responseAdapter->fromDataToControllerResponse($output);

        } catch (EntityException $exception) {
            throw new ServerException('There was an exception while retrieving/deleting Entity objects and/or converting entity objects to human readable data.', $exception);
        } catch (ControllerResponseException $exception) {
            throw new ServerException('There was an exception while converting data to a ControllerResponse object.', $exception);
        }
    }
}
