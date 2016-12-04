<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidRequestException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\NotFoundException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Exceptions\ControllerResponseException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Services\Service;

class RetrieveEntity implements Controller {
    private $responseAdapter;
    private $repository;
    private $adapter;
    public function __construct(ControllerResponseAdapter $responseAdapter, Service $service) {
        $this->responseAdapter = $responseAdapter;
        $this->repository = $service->getRepository()->getEntity();
        $this->adapter = $service->getAdapter()->getEntity();
    }

    public function execute(HttpRequest $request) {

        $retrieve = function(array $input) {

            if (!isset($input['container'])) {
                throw new InvalidRequestException('The container param is mandatory.');
            }

            if (isset($input['uuid'])) {
                return $this->repository->retrieve([
                    'uuid' => $input['uuid'],
                    'container' => $input['container']
                ]);
            }

            if (isset($input['name']) && $input['value']) {

                if (strpos($input['name'], ',') && strpos($input['value'], ',')) {

                    $names = explode(',', $input['name']);
                    $values = explode(',', $input['value']);

                    $params = [
                        'container' => $input['container'],
                        'keynames' => []
                    ];

                    foreach($names as $index => $oneName) {
                        $params['keynames'][] = [
                            'name' => $oneName,
                            'value' => $values[$index]
                        ];
                    }

                    return $this->repository->retrieve($params);
                }

                return $this->repository->retrieve([
                    'container' => $input['container'],
                    'keyname' => [
                        'name' => $input['name'],
                        'value' => $input['value']
                    ]
                ]);

            }

            throw new InvalidRequestException('Some input parameters were missing.');

        };

        try {

            $input = [];
            if ($request->hasParameters()) {
                $input = $request->getParameters();
            }

            $entity = $retrieve($input);
            if (empty($entity)) {
                throw new NotFoundException('The given input did not point to a valid Entity object.');
            }

            $output = $this->adapter->fromEntityToData($entity, true);
            return $this->responseAdapter->fromDataToControllerResponse($output);

        } catch (EntityException $exception) {
            throw new ServerException('There was an exception while retrieving an Entity object and/or converting an Entity object to human readable data.', $exception);
        } catch (ControllerResponseException $exception) {
            throw new ServerException('There was an exception while converting data to a ControllerResponse object.', $exception);
        }
    }
}
