<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Adapters;

interface HttpRequestAdapter {
    public function fromDataToHttpRequests(array $data);
    public function fromDataToHttpRequest(array $data);
}
