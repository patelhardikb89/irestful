<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Action;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Inserts\Insert;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Updates\Update;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Deletes\Delete;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Exceptions\ActionException;

final class ConcreteClassInstructionDatabaseAction implements Action {
    private $insert;
    private $update;
    private $delete;
    public function __construct(Insert $insert = null, Update $update = null, Delete $delete = null) {

        $amount = (empty($insert) ? 0 : 1) + (empty($update) ? 0 : 1) + (empty($delete) ? 0 : 1);
        if ($amount != 1) {
            throw new ActionException('One of these must be non-empty: insert, update, delete.');
        }

        $this->insert = $insert;
        $this->update = $update;
        $this->delete = $delete;

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
