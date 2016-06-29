<?php
namespace iRESTful\Rodson\Domain\Databases\RESTAPIs\Adapters;

interface RESTAPIAdapter {
    public function fromDataToRESTAPI(array $data);
}
