<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Databases\Retrievals\Adapters\RetrievalAdapter;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\HttpRequest;
use iRESTful\Instructions\Infrastructure\Objects\ConcreteInstructionDatabaseRetrieval;
use iRESTful\Instructions\Domain\Databases\Retrievals\Entities\Adapters\EntityAdapter;
use iRESTful\Instructions\Domain\Databases\Retrievals\EntityPartialSets\Adapters\EntityPartialSetAdapter;
use iRESTful\Instructions\Domain\Databases\Retrievals\Multiples\Adapters\MultipleEntityAdapter;
use iRESTful\Instructions\Domain\Databases\Retrievals\Exceptions\RetrievalException;

final class ConcreteInstructionDatabaseRetrievalAdapter implements RetrievalAdapter {
    private $entityAdapter;
    private $entityPartialSetAdapter;
    private $multipleEntityAdapter;
    public function __construct(
        EntityAdapter $entityAdapter,
        EntityPartialSetAdapter $entityPartialSetAdapter,
        MultipleEntityAdapter $multipleEntityAdapter
    ) {
        $this->entityAdapter = $entityAdapter;
        $this->entityPartialSetAdapter = $entityPartialSetAdapter;
        $this->multipleEntityAdapter = $multipleEntityAdapter;
    }

    public function fromStringToRetrieval($string) {

        $matches = [];
        preg_match_all('/([^ ]+) by ([^:]+)\:([^ ]+)/s', $string, $matches);
        if (isset($matches[0][0]) && ($matches[0][0] == $string) && isset($matches[1][0]) && isset($matches[2][0]) && isset($matches[3][0])) {
            $entity = $this->entityAdapter->fromDataToEntity([
                'object_name' => $matches[1][0],
                'property' => [
                    'name' => $matches[2][0],
                    'value' => $matches[3][0]
                ]
            ]);

            return new ConcreteInstructionDatabaseRetrieval(null, $entity);
        }

        $matches = [];
        preg_match_all('/([^ ]+) index ([^ ]+) amount ([^ ]+)/s', $string, $matches);
        if (isset($matches[0][0]) && ($matches[0][0] == $string) && isset($matches[1][0]) && isset($matches[2][0]) && isset($matches[3][0])) {
            $entityPartialSet = $this->entityPartialSetAdapter->fromDataToEntityPartialSet([
                'object_name' => $matches[1][0],
                'index' => $matches[2][0],
                'amount' => $matches[3][0]
            ]);

            return new ConcreteInstructionDatabaseRetrieval(null, null, null, $entityPartialSet);
        }

        $matches = [];
        preg_match_all('/multiple ([^ ]+) by ([^:]+)\:([^ ]+)/s', $string, $matches);
        if (isset($matches[0][0]) && ($matches[0][0] == $string) && isset($matches[1][0]) && isset($matches[2][0]) && isset($matches[3][0])) {
            $multipleEntity = $this->multipleEntityAdapter->fromDataToMultipleEntity([
                'object_name' => $matches[1][0],
                'property' => [
                    'name' => $matches[2][0],
                    'value' => $matches[3][0]
                ]
            ]);

            return new ConcreteInstructionDatabaseRetrieval(null, null, $multipleEntity);
        }

        throw new RetrievalException('The given retrieval command ('.$string.') is invalid.');

    }

    public function fromHttpRequestToRetrieval(HttpRequest $httpRequest) {
        return new ConcreteInstructionDatabaseRetrieval($httpRequest);
    }

}
