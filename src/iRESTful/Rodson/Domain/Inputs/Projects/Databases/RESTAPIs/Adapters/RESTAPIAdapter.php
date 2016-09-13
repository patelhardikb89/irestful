<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Databases\RESTAPIs\Adapters;

interface RESTAPIAdapter {
    public function fromDataToRESTAPI(array $data);
}
