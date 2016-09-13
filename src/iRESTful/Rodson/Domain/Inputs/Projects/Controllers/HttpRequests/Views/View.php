<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Views;

interface View {
    public function isJson();
    public function getData();
}
