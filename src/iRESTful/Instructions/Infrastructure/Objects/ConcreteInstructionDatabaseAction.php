<?php
namespace iRESTful\Instructions\Infrastructure\Objects;
use iRESTful\Instructions\Domain\Databases\Actions\Action;
use iRESTful\Instructions\Domain\Databases\Actions\Inserts\Insert;
use iRESTful\Instructions\Domain\Databases\Actions\Updates\Update;
use iRESTful\Instructions\Domain\Databases\Actions\Deletes\Delete;
use iRESTful\Instructions\Domain\Databases\Actions\Exceptions\ActionException;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\HttpRequest;

final class ConcreteInstructionDatabaseAction implements Action {
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

    public function getData() {

        $output = [];
        if ($this->hasHttpRequest()) {
            $output['http_request'] = $this->getHttpRequest()->getData();
        }

        if ($this->hasInsert()) {
            $output['insert'] = $this->getInsert()->getData();
        }

        if ($this->hasUpdate()) {
            $output['update'] = $this->getUpdate()->getData();
        }

        if ($this->hasDelete()) {
            $output['delete'] = $this->getDelete()->getData();
        }

        return $output;
    }

}
