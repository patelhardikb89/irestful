<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;

interface ControllerRule {
    public function match(HttpRequest $request);
    public function getController();
}
