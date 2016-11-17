<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Configurations;
use iRESTful\LeoPaul\Applications\APIs\Entities\Domain\Configurations\EntityApplicationConfiguration;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionObjectAdapterFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\PDOEntityRepositoryServiceAdapter;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Factories\PDO\PDODeleteSetFactory;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Factories\PDO\PDODeleteEntityFactory;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Factories\PDO\PDOInsertSetFactory;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Factories\PDO\PDOInsertEntityFactory;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Factories\PDO\PDORetrieveEntityFactory;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Factories\PDO\PDORetrieveEntityPartialSetFactory;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Factories\PDO\PDORetrieveRelationFactory;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Factories\PDO\PDORetrieveSetFactory;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Factories\PDO\PDOUpdateEntityFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Configurations\EntityConfiguration;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Factories\PDO\PDOUpdateSetEntityFactory;

final class ConcreteEntityApplicationConfiguration implements EntityApplicationConfiguration {
    private $dbName;
    private $entityObjects;
    public function __construct($dbName, EntityConfiguration $configuration) {
        $this->dbName = $dbName;
        $this->entityObjects = $configuration;
    }

    public function get() {
        return ['rules' => $this->getControllerRules()];
    }

    private function getControllerRules() {

        $entityRepositoryServiceAdapter = new PDOEntityRepositoryServiceAdapter(
            $this->entityObjects->getTransformerObjects(),
            $this->entityObjects->getContainerClassMapper(),
            $this->entityObjects->getInterfaceClassMapper(),
            $this->entityObjects->getDelimiter(),
            $this->entityObjects->getTimezone(),
            getenv('DB_DRIVER'),
            getenv('DB_SERVER'),
            $this->dbName,
            getenv('DB_USERNAME'),
            getenv('DB_PASSWORD')
        );

        $objectAdapterFactory = new ReflectionObjectAdapterFactory(
            $this->entityObjects->getTransformerObjects(),
            $this->entityObjects->getContainerClassMapper(),
            $this->entityObjects->getInterfaceClassMapper(),
            $this->entityObjects->getDelimiter()
        );

        $deleteFactory = new PDODeleteEntityFactory($entityRepositoryServiceAdapter);
        $deleteSetFactory = new PDODeleteSetFactory($entityRepositoryServiceAdapter);
        $insertSetFactory = new PDOInsertSetFactory($entityRepositoryServiceAdapter);
        $insertFactory = new PDOInsertEntityFactory($entityRepositoryServiceAdapter);
        $retrieveFactory = new PDORetrieveEntityFactory($entityRepositoryServiceAdapter);
        $retrievePartialSetFactory = new PDORetrieveEntityPartialSetFactory($entityRepositoryServiceAdapter);
        $retrieveRelationFactory = new PDORetrieveRelationFactory($entityRepositoryServiceAdapter);
        $retrieveSetFactory = new PDORetrieveSetFactory($entityRepositoryServiceAdapter);
        $updateFactory = new PDOUpdateEntityFactory($entityRepositoryServiceAdapter, $objectAdapterFactory);
        $updateSetFactory = new PDOUpdateSetEntityFactory($entityRepositoryServiceAdapter, $objectAdapterFactory);

        return [
            [
                'controller' => $retrievePartialSetFactory->create(),
                'criteria' => [
                    'uri' => '/$container$/partials',
                    'method' => 'get',
                    'query_parameters' => [
                        'container' => '[\s\S]+',
                        'index' => '[0-9]+',
                        'amount' => '[0-9]+'
                    ]
                ]
            ],
            [
                'controller' => $retrieveSetFactory->create(),
                'criteria' => [
                    'uri' => '/$container$',
                    'method' => 'get',
                    'query_parameters' => [
                        'container' => '[\s\S]+'
                    ]
                ]
            ],
            [
                'controller' => $retrieveFactory->create(),
                'criteria' => [
                    'uri' => '/$container$/$name$/$value$',
                    'method' => 'get',
                    'query_parameters' => [
                        'container' => '[\s\S]+',
                        'name' => '[\s\S]+',
                        'value' => '[\s\S]+'
                    ]
                ]
            ],
            [
                'controller' => $retrieveFactory->create(),
                'criteria' => [
                    'uri' => '/$container$/$[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}|uuid$',
                    'method' => 'get',
                    'query_parameters' => [
                        'container' => '[\s\S]+',
                        'uuid' => '[\s\S]+'
                    ]
                ]
            ],
            [
                'controller' => $retrieveRelationFactory->create(),
                'criteria' => [
                    'uri' => '/$master_container$/$master_uuid$/$slave_property$/$slave_container$',
                    'method' => 'get',
                    'query_parameters' => [
                        'master_container' => '[\s\S]+',
                        'master_uuid' => '[\s\S]+',
                        'slave_property' => '[\s\S]+',
                        'slave_container' => '[\s\S]+'
                    ]
                ]
            ],
            [
                'controller' => $updateFactory->create(),
                'criteria' => [
                    'uri' => '/$container$/$[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}|original_uuid$',
                    'method' => 'put',
                    'query_parameters' => [
                        'container' => '[\s\S]+',
                        'original_uuid' => '[\s\S]+'
                    ]
                ]
            ],
            [
                'controller' => $updateSetFactory->create(),
                'criteria' => [
                    'uri' => '/',
                    'method' => 'put'
                ]
            ],
            [
                'controller' => $insertFactory->create(),
                'criteria' => [
                    'uri' => '/$container$',
                    'method' => 'post',
                    'query_parameters' => [
                        'container' => '[\s\S]+'
                    ]
                ]
            ],
            [
                'controller' => $insertSetFactory->create(),
                'criteria' => [
                    'uri' => '/',
                    'method' => 'post'
                ]
            ],
            [
                'controller' => $deleteFactory->create(),
                'criteria' => [
                    'uri' => '/$container$/$[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}|uuid$',
                    'method' => 'delete',
                    'query_parameters' => [
                        'container' => '[\s\S]+',
                        'uuid' => '[\s\S]+'
                    ]
                ]
            ],
            [
                'controller' => $deleteSetFactory->create(),
                'criteria' => [
                    'uri' => '/',
                    'method' => 'delete'
                ]
            ]
        ];
    }
}
