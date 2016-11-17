<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Adapters\SchemaAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Adapters\TableAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteSchema;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Exceptions\SchemaException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Exceptions\TableException;

final class ConcreteSchemaAdapter implements SchemaAdapter {
    private $tableAdapter;
    public function __construct(TableAdapter $tableAdapter) {
        $this->tableAdapter = $tableAdapter;
    }

    public function fromDataToSchema(array $data) {

        if (!isset($data['name'])) {
            throw new SchemaException('The name keyname is mandatory in order to convert data to a Schema object.');
        }

        try {

            $tables = null;
            if (isset($data['container_names']) && is_array($data['container_names'])) {
                $tables = $this->tableAdapter->fromDataToTables($data['container_names']);
            }

            return new ConcreteSchema($data['name'], $tables);

        } catch (TableException $exception) {
            throw new SchemaException('There was an exception while converting container names to Table objects.', $exception);
        }
    }

}
