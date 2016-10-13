<?php
namespace iRESTful\DSLs\Domain\Projects\Databases\RESTAPIs\Adapters;

interface RESTAPIAdapter {
    public function fromDataToRESTAPI(array $data);
}
