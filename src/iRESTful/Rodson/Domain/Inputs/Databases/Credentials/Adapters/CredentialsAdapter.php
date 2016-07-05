<?php
namespace iRESTful\Rodson\Domain\Inputs\Databases\Credentials\Adapters;

interface CredentialsAdapter {
    public function fromDataToCredentials(array $data);
}
