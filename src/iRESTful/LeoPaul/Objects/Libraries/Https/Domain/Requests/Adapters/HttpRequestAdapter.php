<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\Adapters;

interface HttpRequestAdapter {
    public function fromDataToHttpRequest(array $data);
}
