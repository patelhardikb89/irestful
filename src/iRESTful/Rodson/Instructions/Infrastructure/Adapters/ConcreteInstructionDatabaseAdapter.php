<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Databases\Adapters\DatabaseAdapter;
use iRESTful\Rodson\Instructions\Domain\Databases\Exceptions\DatabaseException;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Adapters\RetrievalAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Objects\ConcreteInstructionDatabase;
use iRESTful\Rodson\Instructions\Domain\Databases\Actions\Adapters\ActionAdapter;

final class ConcreteInstructionDatabaseAdapter implements DatabaseAdapter {
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
                return new ConcreteInstructionDatabase($retrieval);
            }

            $action = $this->actionAdapter->fromStringToAction($string);
            return new ConcreteInstructionDatabase(null, $action);
        }

        if (strpos($string, 'retrieve ') === 0) {
            $command = trim(substr($string, strlen('retrieve ')));
            $retrieval = $this->retrievalAdapter->fromStringToRetrieval($command);
            return new ConcreteInstructionDatabase($retrieval);
        }

        $action = $this->actionAdapter->fromStringToAction($string);
        return new ConcreteInstructionDatabase(null, $action);

    }

}
