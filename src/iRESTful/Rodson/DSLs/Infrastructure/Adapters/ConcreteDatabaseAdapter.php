<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Databases\Adapters\DatabaseAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Databases\Relationals\Adapters\RelationalDatabaseAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Databases\Relationals\RelationalDatabase;
use iRESTful\Rodson\DSLs\Domain\Projects\Databases\RESTAPIs\Adapters\RESTAPIAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteDatabase;
use iRESTful\Rodson\DSLs\Domain\Projects\Databases\Exceptions\DatabaseException;
use iRESTful\Rodson\DSLs\Domain\Projects\Databases\Relationals\Exceptions\RelationalDatabaseException;
use iRESTful\Rodson\DSLs\Domain\Projects\Databases\RESTAPIs\Exceptions\RESTAPIException;

final class ConcreteDatabaseAdapter implements DatabaseAdapter {
    private $relationalDatabaseAdapter;
    private $restAPIAdapter;
    public function __construct(RelationalDatabaseAdapter $relationalDatabaseAdapter, RESTAPIAdapter $restAPIAdapter) {
        $this->relationalDatabaseAdapter = $relationalDatabaseAdapter;
        $this->restAPIAdapter = $restAPIAdapter;
    }

    public function fromDataToDatabases(array $data) {
        $output = [];
        foreach($data as $name => $oneData) {
            $oneData['name'] = $name;
            $output[$name] = $this->fromDataToDatabase($oneData);
        }

        return $output;
    }

    public function fromDataToDatabase(array $data) {

        if (!isset($data['name'])) {
            throw new DatabaseException('The name is mandatory in order to convert data to a Database object.');
        }

        if (!isset($data['type'])) {
            throw new DatabaseException('The type is mandatory in order to convert data to a Database object.');
        }

        try {

            $relationalDatabase = null;
            if ($data['type'] == 'relational') {
                $relationalDatabase = $this->relationalDatabaseAdapter->fromDataToRelationalDatabase($data);
            }

            $restAPI = null;
            if ($data['type'] == 'rest_api') {
                $restAPI = $this->restAPIAdapter->fromDataToRESTAPI($data);
            }

            return new ConcreteDatabase($data['name'], $relationalDatabase, $restAPI);

        } catch (RelationalDatabaseException $exception) {
            throw new DatabaseException('There was an exception while converting data to a RelationalDatabase object.', $exception);
        } catch (RESTAPIException $exception) {
            throw new DatabaseException('There was an exception while converting data to a RESTAPI object.', $exception);
        }
    }

}
