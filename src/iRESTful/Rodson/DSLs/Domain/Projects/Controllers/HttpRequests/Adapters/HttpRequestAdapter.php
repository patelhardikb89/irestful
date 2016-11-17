<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Controllers\HttpRequests\Adapters;

interface HttpRequestAdapter {
    public function fromDataToHttpRequests(array $data);
    public function fromDataToHttpRequest(array $data);
}
