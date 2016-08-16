<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Action;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Inserts\Insert;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Updates\Update;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Deletes\Delete;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Exceptions\ActionException;
use iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\HttpRequest;

final class ConcreteClassInstructionDatabaseAction implements Action {
    private $httpRequest;
    private $insert;
    private $update;
    private $delete;
    public function __construct(HttpRequest $httpRequest = null, Insert $insert = null, Update $update = null, Delete $delete = null) {

        $amount = (empty($httpRequest) ? 0 : 1) + (empty($insert) ? 0 : 1) + (empty($update) ? 0 : 1) + (empty($delete) ? 0 : 1);
        if ($amount != 1) {
            throw new ActionException('One of these must be non-empty: httpRequest, insert, update, delete.');
        }

        if (!empty($httpRequest)) {
            $action = $httpRequest->getCommand()->getAction();
            if (!$action->isInsert() && !$action->isDelete() && !$action->isUpdate()) {
                throw new ActionException('The given HttpRequest object is invalid for an action.  It must be contain either an insert, update or a delete action.');
            }
        }

        $this->httpRequest = $httpRequest;
        $this->insert = $insert;
        $this->update = $update;
        $this->delete = $delete;

    }

    public function hasHttpRequest() {
        return !empty($this->httpRequest);
    }

    public function getHttpRequest() {
        return $this->httpRequest;
    }

    public function hasInsert() {
        return !empty($this->insert);
    }

    public function getInsert() {
        return $this->insert;
    }

    public function hasUpdate() {
        return !empty($this->update);
    }

    public function getUpdate() {
        return $this->update;
    }

    public function hasDelete() {
        return !empty($this->delete);
    }

    public function getDelete() {
        return $this->delete;
    }

}
