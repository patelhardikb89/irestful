<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Database;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Retrieval;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Action;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Exceptions\DatabaseException;

final class ConcreteClassInstructionDatabase implements Database {
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

    public function getData() {
        $output = [];
        if ($this->hasRetrieval()) {
            $output['retrieval'] = $this->getRetrieval()->getData();
        }

        if ($this->hasAction()) {
            $output['action'] = $this->getAction()->getData();
        }

        return $output;
    }

}
