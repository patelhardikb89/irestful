<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Objects\ConcreteJsonControllerResponse;

final class ConcreteJsonControllerResponseAdapter implements ControllerResponseAdapter {

    public function __construct() {

    }

    public function fromDataToControllerResponse(array $data) {
        return new ConcreteJsonControllerResponse($data);

    }

}
