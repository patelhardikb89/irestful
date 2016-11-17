{% autoescape false %}
{% import "includes/returned.hashmap.php" as fn %}
<?php
namespace {{namespace.path}};
use iRESTful\Applications\Libraries\PDO\Installations\Database as EngineDatabase;
use iRESTful\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionClassSchemaAdapterFactory;
use iRESTful\Applications\Libraries\PDODatabases\Infrastructure\Factories\PDOSchemaAdapterFactory;

final class {{namespace.name}} {

    public static function install() {

        EngineDatabase::reset();

        $containerClassMapper = [{{- fn.returnedHashMap(object_configuration.container_class_mapper) -}}];
        $interfaceClassMapper = [{{- fn.returnedHashMap(object_configuration.interface_class_mapper) -}}];
        $engine = 'InnoDB';
        $fieldDelimiter = '{{object_configuration.delimiter}}';
        $schemaAdapterFactory = new ReflectionClassSchemaAdapterFactory($containerClassMapper, $interfaceClassMapper, $engine, $fieldDelimiter);
        $pdoSchemaAdapterFactory = new PDOSchemaAdapterFactory($fieldDelimiter);
        $schema = $schemaAdapterFactory->create()->fromDataToSchema([
            'name' => getenv('DB_NAME'),
            'container_names' => array_keys($containerClassMapper)
        ]);

        $queries = $pdoSchemaAdapterFactory->create()->fromSchemaToSQLQueries($schema);
        foreach($queries as $oneQuery) {
            EngineDatabase::execute($oneQuery);
        }

    }

}
{% endautoescape %}
