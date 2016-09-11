<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Adapters\RetrievalAdapter;
use iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\HttpRequest;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionDatabaseRetrieval;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Entities\Adapters\EntityAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets\Adapters\EntityPartialSetAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Multiples\Adapters\MultipleEntityAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Exceptions\RetrievalException;

final class ConcreteClassInstructionDatabaseRetrievalAdapter implements RetrievalAdapter {
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

            return new ConcreteClassInstructionDatabaseRetrieval(null, $entity);
        }

        $matches = [];
        preg_match_all('/([^ ]+) index ([^ ]+) amount ([^ ]+)/s', $string, $matches);
        if (isset($matches[0][0]) && ($matches[0][0] == $string) && isset($matches[1][0]) && isset($matches[2][0]) && isset($matches[3][0])) {
            $entityPartialSet = $this->entityPartialSetAdapter->fromDataToEntityPartialSet([
                'object_name' => $matches[1][0],
                'index' => $matches[2][0],
                'amount' => $matches[3][0]
            ]);

            return new ConcreteClassInstructionDatabaseRetrieval(null, null, null, $entityPartialSet);
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

            return new ConcreteClassInstructionDatabaseRetrieval(null, null, $multipleEntity);
        }

        throw new RetrievalException('The given retrieval command ('.$string.') is invalid.');

    }

    public function fromHttpRequestToRetrieval(HttpRequest $httpRequest) {
        return new ConcreteClassInstructionDatabaseRetrieval($httpRequest);
    }

}
