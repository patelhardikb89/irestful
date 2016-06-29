<?php
namespace iRESTful\Rodson\Domain\Databases\Credentials\Adapters;

interface CredentialsAdapter {
    public function fromDataToCredentials(array $data);
}
