<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters;

interface ControllerResponseAdapter {
    public function fromDataToControllerResponse(array $data);
}
