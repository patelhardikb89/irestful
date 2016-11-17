<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\EntityRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\Adapters\EntityRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Adapters\RequestAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Keyname;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Exceptions\RequestException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Exceptions\UuidException;

final class ConcreteRequestAdapter implements RequestAdapter {
    private $entityRetrieverCriteriaAdapter;
    private $uuidAdapter;
    public function __construct(EntityRetrieverCriteriaAdapter $entityRetrieverCriteriaAdapter, UuidAdapter $uuidAdapter) {
        $this->entityRetrieverCriteriaAdapter = $entityRetrieverCriteriaAdapter;
        $this->uuidAdapter = $uuidAdapter;
    }

    public function fromDataToEntityRequest(array $data) {

        try {

            $criteria = $this->entityRetrieverCriteriaAdapter->fromDataToRetrieverCriteria($data);
            return $this->fromEntityRetrieverCriteriaToRequest($criteria);

        } catch (EntityException $exception) {
            throw new RequestException('There was an exception while converting data to an EntityRetrieverCriteria object.', $exception);
        }
    }

    public function fromEntityRetrieverCriteriaToRequest(EntityRetrieverCriteria $criteria) {

        $createQueryFromUuid = function($containerName, Uuid $uuid) {
            $uuid = $uuid->get();
            return [
                'query' => 'select * from '.$containerName.' where uuid = :uuid limit 0,1;',
                'params' => ['uuid' => $uuid]
            ];
        };

        $createQueryFromKeynames = function($containerName, array $keynames) {

            $comparisons = [];
            $params = [];
            foreach($keynames as $oneKeyname) {
                $name = $oneKeyname->getName();
                $value = $oneKeyname->getValue();

                if ($name == 'uuid') {
                    try {
                        $value = $this->uuidAdapter->fromStringToUuid($value)->get();
                    } catch (UuidException $exception) {}
                }

                $comparisons[] = $name.' = :'.$name;
                $params[$name] = $value;
            }

            return [
                'query' => 'select * from '.$containerName.' where '.implode(' and ', $comparisons).' limit 0,1;',
                'params' => $params
            ];
        };

        $createQueryFromKeyname = function($containerName, Keyname $keyname) {
            $name = $keyname->getName();
            $value = $keyname->getValue();

            if ($name == 'uuid') {
                try {
                    $value = $this->uuidAdapter->fromStringToUuid($value)->get();
                } catch (UuidException $exception) {}
            }

            return [
                'query' => 'select * from '.$containerName.' where '.$name.' = :'.$name.' limit 0,1;',
                'params' => [$name => $value]
            ];

        };

        $containerName = $criteria->getContainerName();
        if ($criteria->hasUuid()) {
            $uuid = $criteria->getUuid();
            return $createQueryFromUuid($containerName, $uuid);
        }

        if ($criteria->hasKeynames()) {
            $keynames = $criteria->getKeynames();
            return $createQueryFromKeynames($containerName, $keynames);
        }

        if ($criteria->hasKeyname()) {
            $keyname = $criteria->getKeyname();
            return $createQueryFromKeyname($containerName, $keyname);
        }

        throw new RequestException('There is no valid criteria inside the EntityRetrieverCriteria object.');

    }
}
