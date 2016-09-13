<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Adapters\Adapters;

interface HttpRequestAdapterAdapter {
    public function fromDataToHttpRequestAdapter(array $data);
}
