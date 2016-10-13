<?php
namespace iRESTful\Authenticated\Installations;
use iRESTful\Applications\Libraries\PDO\Installations\Database as EngineDatabase;
use iRESTful\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionClassSchemaAdapterFactory;
use iRESTful\Applications\Libraries\PDODatabases\Infrastructure\Factories\PDOSchemaAdapterFactory;

final class AuthenticatedInstallation {

    public static function install() {

        EngineDatabase::reset();

        $containerClassMapper = [                        'endpoint' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteEndpoint',
    'api' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteApi',
    'params' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteParams',
    'registration' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteRegistration',
    'resource' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteResource',
    'shared_resource' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteSharedResource',
    'owner' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteOwner',
    'software' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteSoftware',
    'user' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteUser',
    'role' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteRole',
    'permission' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcretePermission'
    ];
        $interfaceClassMapper = [                        'iRESTful\Authenticated\Domain\Entities\Endpoint' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteEndpoint',
    'iRESTful\Authenticated\Domain\Entities\Api' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteApi',
    'iRESTful\Authenticated\Domain\Entities\Params' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteParams',
    'iRESTful\Authenticated\Domain\Entities\Registration' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteRegistration',
    'iRESTful\Authenticated\Domain\Entities\Resource' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteResource',
    'iRESTful\Authenticated\Domain\Entities\SharedResource' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteSharedResource',
    'iRESTful\Authenticated\Domain\Entities\Owner' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteOwner',
    'iRESTful\Authenticated\Domain\Entities\Software' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteSoftware',
    'iRESTful\Authenticated\Domain\Entities\User' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteUser',
    'iRESTful\Authenticated\Domain\Entities\Role' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteRole',
    'iRESTful\Authenticated\Domain\Entities\Permission' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcretePermission',
    'iRESTful\Authenticated\Domain\Objects\Pattern' => 'iRESTful\Authenticated\Infrastructure\Objects\ConcretePattern',
    'iRESTful\Authenticated\Domain\Objects\ParamPattern' => 'iRESTful\Authenticated\Infrastructure\Objects\ConcreteParamPattern',
    'iRESTful\Authenticated\Domain\Objects\Credentials' => 'iRESTful\Authenticated\Infrastructure\Objects\ConcreteCredentials',
    'iRESTful\Authenticated\Domain\Types\BaseUrls\BaseUrl' => 'iRESTful\Authenticated\Infrastructure\Types\ConcreteBaseUrl',
    'iRESTful\Authenticated\Domain\Types\Keynames\Keyname' => 'iRESTful\Authenticated\Infrastructure\Types\ConcreteKeyname',
    'iRESTful\Authenticated\Domain\Types\Uris\Uri' => 'iRESTful\Authenticated\Infrastructure\Types\ConcreteUri',
    'iRESTful\Authenticated\Domain\Types\StringNumerics\StringNumeric' => 'iRESTful\Authenticated\Infrastructure\Types\ConcreteStringNumeric'
    ];
        $engine = 'InnoDB';
        $fieldDelimiter = '___';
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
