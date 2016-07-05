<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Inputs\Databases\Relationals\Adapters\RelationalDatabaseAdapter;
use iRESTful\Rodson\Domain\Inputs\Databases\Credentials\Adapters\CredentialsAdapter;
use iRESTful\Rodson\Domain\Inputs\Databases\Relationals\Exceptions\RelationalDatabaseException;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteRelationalDatabase;
use iRESTful\Rodson\Domain\Inputs\Databases\Credentials\Exceptions\CredentialsException;

final class ConcreteRelationalDatabaseAdapter implements RelationalDatabaseAdapter {
    private $credentialsAdapter;
    public function __construct(CredentialsAdapter $credentialsAdapter) {
        $this->credentialsAdapter = $credentialsAdapter;
    }

    public function fromDataToRelationalDatabase(array $data) {

        if (!isset($data['driver'])) {
            throw new RelationalDatabaseException('The driver keyname is mandatory in order to convert data to a RelationalDatabase object.');
        }

        if (!isset($data['hostname'])) {
            throw new RelationalDatabaseException('The hostname keyname is mandatory in order to convert data to a RelationalDatabase object.');
        }

        try {

            $credentials = null;
            if (isset($data['credentials'])) {
                $credentials = $this->credentialsAdapter->fromDataToCredentials($data['credentials']);
            }

            return new ConcreteRelationalDatabase($data['driver'], $data['hostname'], $credentials);

        } catch (CredentialsException $exception) {
            throw new RelationalDatabaseException('There was an exception while converting data to a Credentials object.', $exception);
        }

    }

}
