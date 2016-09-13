<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Databases\Credentials\Adapters;

interface CredentialsAdapter {
    public function fromDataToCredentials(array $data);
}
