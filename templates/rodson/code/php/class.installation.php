{% autoescape false %}
{% import "includes/returned.hashmap.php" as fn %}
<?php
namespace {{namespace.path}};
use {{object_configuration.namespace.all}};
use iRESTful\LeoPaul\Applications\Libraries\PDO\Installations\Database as EngineDatabase;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionClassSchemaAdapterFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Infrastructure\Factories\PDOSchemaAdapterFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntitySetServiceWithSubEntitiesFactory;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionObjectAdapterFactory;

final class {{namespace.name}} {

    public static function install() {

        EngineDatabase::reset();

        $engine = 'InnoDB';
        $objectConfiguration = new {{object_configuration.namespace.name}}();
        $containerClassMapper = $objectConfiguration->getContainerClassMapper();
        $interfaceClassMapper = $objectConfiguration->getInterfaceClassMapper();
        $transformerObjects = $objectConfiguration->getTransformerObjects();
        $fieldDelimiter = $objectConfiguration->getDelimiter();

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

        $entitySetServiceFactory = new PDOEntitySetServiceWithSubEntitiesFactory(
            $transformerObjects,
            $containerClassMapper,
            $interfaceClassMapper,
            $fieldDelimiter,
            $objectConfiguration->getTimezone(),
            getenv('DB_DRIVER'),
            getenv('DB_SERVER'),
            getenv('DB_NAME'),
            getenv('DB_USERNAME'),
            getenv('DB_PASSWORD')
        );

        $objectAdapterFactory = new ReflectionObjectAdapterFactory(
            $transformerObjects,
            $containerClassMapper,
            $interfaceClassMapper,
            $fieldDelimiter
        );

        $data = self::getData();
        $objects = $objectAdapterFactory->create()->fromDataToObjects($data);
        $entitySetServiceFactory->create()->insert($objects);

    }

    private static function getData() {
        return json_decode('{{- entity_datas|json_encode(constant('JSON_PRETTY_PRINT'))|raw -}}', true);
    }

}
{% endautoescape %}
