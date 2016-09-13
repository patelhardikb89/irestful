<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Views\Adapters;

interface ViewAdapter {
    public function fromStringToView($string);
}
