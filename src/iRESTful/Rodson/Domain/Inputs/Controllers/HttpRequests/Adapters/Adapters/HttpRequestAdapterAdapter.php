<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\Adapters\Adapters;

interface HttpRequestAdapterAdapter {
    public function fromDataToHttpRequestAdapter(array $data);
}
