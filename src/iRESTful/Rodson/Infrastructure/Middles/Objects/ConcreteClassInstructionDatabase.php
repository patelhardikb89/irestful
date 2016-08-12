<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Database;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Retrieval;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Retrieval;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Action;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Exceptions\DatabaseException;

final class ConcreteClassInstructionDatabase implements Database {
    private $retrieval;
    private $action;
    private $actions;
    public function __construct(Retrieval $retrieval = null, Action $action = null, array $actions = null) {

        if (empty($actions)) {
            $actions = null;
        }

        $amount = (empty($retrieval) ? 0 : 1) + (empty($action) ? 0 : 1) + (empty($actions) ? 0 : 1);
        if ($amount != 1) {
            throw new DatabaseException('One of these must be non-empty: retrieval, action, actions.  '.$amount.' given.');
        }

        $this->retrieval = $retrieval;
        $this->action = $action;
        $this->actions = $actions;

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

    public function hasActions() {
        return !empty($this->actions);
    }

    public function getActions() {
        return $this->actions;
    }

}
