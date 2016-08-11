<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\Views\Adapters;

interface ViewAdapter {
    public function fromStringToView($string);
}
