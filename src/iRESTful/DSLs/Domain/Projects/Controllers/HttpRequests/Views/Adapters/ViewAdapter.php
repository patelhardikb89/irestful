<?php
namespace iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Views\Adapters;

interface ViewAdapter {
    public function fromStringToView($string);
}
