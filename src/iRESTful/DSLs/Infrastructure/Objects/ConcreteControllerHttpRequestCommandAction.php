<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Actions\Action;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Actions\Exceptions\ActionException;

final class ConcreteControllerHttpRequestCommandAction implements Action {
    private $isRetrieval;
    private $isInsert;
    private $isUpdate;
    private $isDelete;
    public function __construct(bool $isRetrieval, bool $isInsert, bool $isUpdate, bool $isDelete) {

        $amount = ($isRetrieval ? 1 : 0) + ($isInsert ? 1 : 0) + ($isUpdate ? 1 : 0) + ($isDelete ? 1 : 0);
        if ($amount != 1) {
            throw new ActionException('The action can be either retrieve, insert, update or delete.  '.$amount.' provided.');
        }

        $this->isRetrieval = (bool) $isRetrieval;
        $this->isInsert = (bool) $isInsert;
        $this->isUpdate = (bool) $isUpdate;
        $this->isDelete = (bool) $isDelete;

    }

    public function isRetrieval(): bool {
        return $this->isRetrieval;
    }

    public function isInsert(): bool {
        return $this->isInsert;
    }

    public function isUpdate(): bool {
        return $this->isUpdate;
    }

    public function isDelete(): bool {
        return $this->isDelete;
    }

}
