<?php
namespace iRESTful\DSLs\Domain\Projects\Databases\Credentials\Adapters;

interface CredentialsAdapter {
    public function fromDataToCredentials(array $data);
}
