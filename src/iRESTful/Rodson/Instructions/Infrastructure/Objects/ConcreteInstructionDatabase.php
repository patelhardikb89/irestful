<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Objects;
use iRESTful\Rodson\Instructions\Domain\Databases\Database;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Retrieval;
use iRESTful\Rodson\Instructions\Domain\Databases\Actions\Action;
use iRESTful\Rodson\Instructions\Domain\Databases\Exceptions\DatabaseException;

final class ConcreteInstructionDatabase implements Database {
    private $retrieval;
    private $action;
    public function __construct(Retrieval $retrieval = null, Action $action = null) {

        $amount = (empty($retrieval) ? 0 : 1) + (empty($action) ? 0 : 1);
        if ($amount != 1) {
            throw new DatabaseException('One of these must be non-empty: retrieval, action.  '.$amount.' given.');
        }

        $this->retrieval = $retrieval;
        $this->action = $action;

    }

    public function hasRetrieval() {
        return !empty($this->retrieval);
    }

    public function getRetrieval() {
        return $this->retrieval;
    }

    public function hasAction() {
        return !empty($this->action);
    }

    public function getAction() {
        return $this->action;
    }

}
