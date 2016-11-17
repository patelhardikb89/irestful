<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses;

interface ControllerResponse {
    public function getHeaders();
    public function hasOutput();
    public function getOutput();
}
