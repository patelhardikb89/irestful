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

class RetrieveSet implements Controller {
    private $responseAdapter;
    private $repository;
    private $adapter;
    public function __construct(ControllerResponseAdapter $responseAdapter, Service $service) {
        $this->responseAdapter = $responseAdapter;
        $this->repository = $service->getRepository()->getEntitySet();
        $this->adapter = $service->getAdapter()->getEntity();
    }

    public function execute(HttpRequest $request) {

        $retrieve = function(array $input) {

            if (!isset($input['container'])) {
                throw new InvalidRequestException('The container index is mandatory.');
            }

            if (isset($input['uuids'])) {

                $params = [
                    'container' => $input['container'],
                    'uuids' => $input['uuids']
                ];

                if (isset($input['ordering'])) {
                    $params['ordering'] = $input['ordering'];
                }

                return $this->repository->retrieve($params);
            }

            if (isset($input['name']) && $input['value']) {

                $params = [
                    'container' => $input['container'],
                    'keyname' => [
                        'name' => $input['name'],
                        'value' => $input['value']
                    ]
                ];

                if (isset($input['ordering'])) {
                    $params['ordering'] = $input['ordering'];
                }

                return $this->repository->retrieve($params);
            }

            throw new InvalidRequestException('Some input parameters were missing.');

        };

        try {

            $input = [];
            if ($request->hasParameters()) {
                $input = $request->getParameters();
            }

            $entities = $retrieve($input);
            $output = $this->adapter->fromEntitiesToData($entities, true);
            return $this->responseAdapter->fromDataToControllerResponse($output);

        } catch (EntityException $exception) {
            throw new ServerException('There was an exception while converting entities to human readable data.', $exception);
        } catch (EntitySetException $exception) {
            throw new ServerException('There was an exception while retrieving Entity objects.', $exception);
        } catch (ControllerResponseException $exception) {
            throw new ServerException('There was an exception while converting data to a ControllerResponse object.', $exception);
        }
    }

}
