<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Adapters\RetrievalAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\HttpRequests\HttpRequest;
use iRESTful\Rodson\Instructions\Infrastructure\Objects\ConcreteInstructionDatabaseRetrieval;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Entities\Adapters\EntityAdapter;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\EntityPartialSets\Adapters\EntityPartialSetAdapter;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Multiples\Adapters\MultipleEntityAdapter;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Exceptions\RetrievalException;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Relations\Adapters\RelatedEntityAdapter;

final class ConcreteInstructionDatabaseRetrievalAdapter implements RetrievalAdapter {
    private $entityAdapter;
    private $entityPartialSetAdapter;
    private $multipleEntityAdapter;
    private $relatedEntityAdapter;
    public function __construct(
        EntityAdapter $entityAdapter,
        EntityPartialSetAdapter $entityPartialSetAdapter,
        MultipleEntityAdapter $multipleEntityAdapter,
        RelatedEntityAdapter $relatedEntityAdapter
    ) {
        $this->entityAdapter = $entityAdapter;
        $this->entityPartialSetAdapter = $entityPartialSetAdapter;
        $this->multipleEntityAdapter = $multipleEntityAdapter;
        $this->relatedEntityAdapter = $relatedEntityAdapter;
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

        $matches = [];
        preg_match_all('/([^ ]+) master-uuid ([^ ]+) slave-property ([^ ]+) slave-container ([^ ]+)/s', $string, $matches);
        if (isset($matches[0][0]) && ($matches[0][0] == $string) && isset($matches[1][0]) && isset($matches[2][0]) && isset($matches[3][0]) && isset($matches[4][0])) {
            $relatedEntity = $this->relatedEntityAdapter->fromDataToRelatedEntity([
                'master' => [
                    'container' => $matches[1][0],
                    'uuid' => $matches[2][0]
                ],
                'slave' => [
                    'property' => $matches[3][0],
                    'container' => $matches[4][0]
                ]
            ]);

            return new ConcreteInstructionDatabaseRetrieval(null, null, null, null, $relatedEntity);
        }


        throw new RetrievalException('The given retrieval command ('.$string.') is invalid.');

    }

    public function fromHttpRequestToRetrieval(HttpRequest $httpRequest) {
        return new ConcreteInstructionDatabaseRetrieval($httpRequest);
    }

}
