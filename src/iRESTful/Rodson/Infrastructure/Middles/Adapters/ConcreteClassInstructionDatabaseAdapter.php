<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Adapters\DatabaseAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Exceptions\DatabaseException;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Adapters\RetrievalAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionDatabase;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Adapters\ActionAdapter;

final class ConcreteClassInstructionDatabaseAdapter implements DatabaseAdapter {
    private $retrievalAdapter;
    private $actionAdapter;
    private $httpRequests;
    public function __construct(
        RetrievalAdapter $retrievalAdapter,
        ActionAdapter $actionAdapter,
        array $httpRequests = null
    ) {

        if (empty($httpRequests)) {
            $httpRequests = null;
        }

        $this->retrievalAdapter = $retrievalAdapter;
        $this->actionAdapter = $actionAdapter;
        $this->httpRequests = $httpRequests;
    }

    public function fromStringToDatabase($string) {

        if (strpos($string, 'execute ') === 0) {
            $keyname = trim(substr($string, strlen('execute ')));
            if (!isset($this->httpRequests[$keyname])) {
                throw new DatabaseException('The command ('.$string.') reference an HttpRequest ('.$keyname.') that is not defined.');
            }

            if ($this->httpRequests[$keyname]->getCommand()->getAction()->isRetrieval()) {
                $retrieval = $this->retrievalAdapter->fromHttpRequestToRetrieval($this->httpRequests[$keyname]);
                return new ConcreteClassInstructionDatabase($retrieval);
            }

            //action
        }

        if (strpos($string, 'retrieve ') === 0) {
            $command = trim(substr($string, strlen('retrieve ')));
            $retrieval = $this->retrievalAdapter->fromStringToRetrieval($command);
            return new ConcreteClassInstructionDatabase($retrieval);
        }


        print_r([$string, 'ConcreteClassInstructionDatabaseAdapter->fromStringToDatabase']);
        die();


        print_r([$this->httpRequests, $string, 'ConcreteClassInstructionDatabaseAdapter->fromStringToDatabase']);
        die();

    }

}
