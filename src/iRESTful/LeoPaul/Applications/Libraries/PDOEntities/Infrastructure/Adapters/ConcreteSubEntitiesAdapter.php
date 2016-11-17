<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Subs\Adapters\SubEntitiesAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\SubEntities;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Adapters\RequestEntityAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Subs\Exceptions\RequestSubEntitiesException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Exceptions\RequestEntityException;

final class ConcreteSubEntitiesAdapter implements SubEntitiesAdapter {
    private $requestEntityAdapter;
    public function __construct(RequestEntityAdapter $requestEntityAdapter) {
        $this->requestEntityAdapter = $requestEntityAdapter;
    }

    public function fromSubEntitiesToRequests(SubEntities $subEntities) {

        try {

            $subUpdateRequests = [];
            if ($subEntities->hasExistingEntities()) {
                $existingEntities = $subEntities->getExistingEntities();
                $subUpdateRequests = $this->requestEntityAdapter->fromEntitiesToUpdateRequests($existingEntities, $existingEntities);
            }

            $subInsertRequests = [];
            if ($subEntities->hasNewEntities()) {
                $newEntities = $subEntities->getNewEntities();
                $subInsertRequests = $this->requestEntityAdapter->fromEntitiesToInsertRequests($newEntities);
            }

            return [
                'insert' => $subInsertRequests,
                'update' => $subUpdateRequests
            ];

        } catch (RequestEntityException $exception) {
            throw new RequestSubEntitiesException('There was an exception while converting Entity object to insert/update requests.', $exception);
        }

    }

}
