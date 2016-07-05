<?php
namespace iRESTful\Rodson\Domain\Inputs\Databases\RESTAPIs\Adapters;

interface RESTAPIAdapter {
    public function fromDataToRESTAPI(array $data);
}
