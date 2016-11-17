<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Objects;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\ControllerResponse;

final class ConcreteJsonControllerResponse implements ControllerResponse {
    private $data;
    public function __construct(array $data = null) {

        if (empty($data)) {
            $data = [];
        }

        $this->data = $data;
    }

    public function getHeaders() {
        return [
            'Content-Type: application/json'
        ];
    }

    public function hasOutput() {
        return true;
    }

    public function getOutput() {
        return json_encode($this->data);
    }

}
