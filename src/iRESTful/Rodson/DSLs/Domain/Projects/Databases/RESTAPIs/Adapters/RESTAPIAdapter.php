<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Databases\RESTAPIs\Adapters;

interface RESTAPIAdapter {
    public function fromDataToRESTAPI(array $data);
}
