<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;

interface Controller {
    public function execute(HttpRequest $request);
}
