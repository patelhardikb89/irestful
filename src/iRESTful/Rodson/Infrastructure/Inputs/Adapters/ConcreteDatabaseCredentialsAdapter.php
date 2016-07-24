<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Databases\Credentials\Adapters\CredentialsAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteDatabaseCredentials;
use iRESTful\Rodson\Domain\Inputs\Databases\Credentials\Exceptions\CredentialsException;

final class ConcreteDatabaseCredentialsAdapter implements CredentialsAdapter {

    public function __construct() {

    }

    public function fromDataToCredentials(array $data) {

        if (!isset($data['username'])) {
            throw new CredentialsException('The username keyname is mandatory in order to convert data to a Credentials object.');
        }

        $password = null;
        if (isset($data['password'])) {
            $password = $data['password'];
        }

        return new ConcreteDatabaseCredentials($data['username'], $password);

    }

}
