<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\Adapters;

interface HttpRequestAdapter {
    public function fromDataToHttpRequests(array $data);
    public function fromDataToHttpRequest(array $data);
}
