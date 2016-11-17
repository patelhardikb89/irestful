<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Adapters\RequestAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\Adapters\EntityRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\EntityRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Exceptions\RequestException;

final class ConcreteRequestAdapter implements RequestAdapter {
    private $entityRetrieverCriteriaAdapter;
    private $port;
    private $headers;
    public function __construct(EntityRetrieverCriteriaAdapter $entityRetrieverCriteriaAdapter, $port = 80, array $headers = null) {
        $this->entityRetrieverCriteriaAdapter = $entityRetrieverCriteriaAdapter;
        $this->port = $port;
        $this->headers = $headers;
    }

    public function fromDataToEntityHttpRequestData(array $data) {

        try {

            $criteria = $this->entityRetrieverCriteriaAdapter->fromDataToRetrieverCriteria($data);
            return $this->fromEntityRetrieverCriteriaToHttpRequestData($criteria);

        } catch (EntityException $exception) {
            throw new RequestException('There was an exception while converting data to an EntityRetrieverCriteria object.', $exception);
        }

    }

    public function fromEntityRetrieverCriteriaToHttpRequestData(EntityRetrieverCriteria $criteria) {

        $createURI = function() use($criteria) {
            $containerName = $criteria->getContainerName();
            $uri = '/'.$containerName;
            if ($criteria->hasUuid()) {
                $uuid = $criteria->getUuid()->getHumanReadable();
                return $uri.'/'.$uuid;
            }

            if ($criteria->hasKeynames()) {
                $names = [];
                $values = [];
                $keynames = $criteria->getKeynames();
                foreach($keynames as $oneKeyname) {
                    $names[] = $oneKeyname->getName();
                    $values[] = $oneKeyname->getValue();
                }

                return $uri.'/'.implode(',', $names).'/'.implode(',', $values);
            }

            if ($criteria->hasKeyname()) {
                $keyname = $criteria->getKeyname();
                $name = $keyname->getName();
                $value = $keyname->getValue();
                return $uri.'/'.$name.'/'.$value;
            }

            throw new RequestException('The EntityRetrieverCriteria object did not have any criteria.');
        };

        $uri = $createURI();
        return [
            'uri' => $uri,
            'method' => 'get',
            'port' => $this->port,
            'headers' => $this->headers
        ];
    }

}
