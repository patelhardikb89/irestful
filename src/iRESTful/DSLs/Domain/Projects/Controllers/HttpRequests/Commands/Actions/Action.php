<?php
namespace iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Actions;

interface Action {
    public function isRetrieval();
    public function isInsert();
    public function isUpdate();
    public function isDelete();
}
