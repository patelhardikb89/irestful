<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Databases\Relationals\Adapters\RelationalDatabaseAdapter;
use iRESTful\DSLs\Domain\Projects\Databases\Credentials\Adapters\CredentialsAdapter;
use iRESTful\DSLs\Domain\Projects\Databases\Relationals\Exceptions\RelationalDatabaseException;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteRelationalDatabase;
use iRESTful\DSLs\Domain\Projects\Databases\Credentials\Exceptions\CredentialsException;

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

        if (!isset($data['engine'])) {
            throw new RelationalDatabaseException('The engine keyname is mandatory in order to convert data to a RelationalDatabase object.');
        }

        try {

            $credentials = null;
            if (isset($data['credentials'])) {
                $credentials = $this->credentialsAdapter->fromDataToCredentials($data['credentials']);
            }

            return new ConcreteRelationalDatabase($data['driver'], $data['hostname'], $data['engine'], $credentials);

        } catch (CredentialsException $exception) {
            throw new RelationalDatabaseException('There was an exception while converting data to a Credentials object.', $exception);
        }

    }

}
