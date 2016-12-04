<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Configurations;
use iRESTful\LeoPaul\Applications\APIs\Entities\Domain\Configurations\EntityApplicationConfiguration;
use iRESTful\LeoPaul\Objects\Entities\Entities\Configurations\EntityConfiguration;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOServiceFactory;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Adapters\ConcreteJsonControllerResponseAdapter;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers\DeleteEntity;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers\DeleteSet;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers\InsertEntity;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers\InsertSet;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers\RetrieveEntity;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers\RetrieveEntityPartialSet;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers\RetrieveRelation;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers\RetrieveSet;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers\UpdateEntity;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers\UpdateSet;

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
        
        $serviceFactory = new PDOServiceFactory(
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

        $service = $serviceFactory->create();
        $responseAdapter = new ConcreteJsonControllerResponseAdapter();

        return [
            [
                'controller' => new RetrieveEntityPartialSet($responseAdapter, $service),
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
                'controller' => new RetrieveSet($responseAdapter, $service),
                'criteria' => [
                    'uri' => '/$container$',
                    'method' => 'get',
                    'query_parameters' => [
                        'container' => '[\s\S]+'
                    ]
                ]
            ],
            [
                'controller' => new RetrieveEntity($responseAdapter, $service),
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
                'controller' => new RetrieveEntity($responseAdapter, $service),
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
                'controller' => new RetrieveRelation($responseAdapter, $service),
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
                'controller' => new UpdateEntity($responseAdapter, $service),
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
                'controller' => new UpdateSet($responseAdapter, $service),
                'criteria' => [
                    'uri' => '/',
                    'method' => 'put'
                ]
            ],
            [
                'controller' => new InsertEntity($responseAdapter, $service),
                'criteria' => [
                    'uri' => '/$container$',
                    'method' => 'post',
                    'query_parameters' => [
                        'container' => '[\s\S]+'
                    ]
                ]
            ],
            [
                'controller' => new InsertSet($responseAdapter, $service),
                'criteria' => [
                    'uri' => '/',
                    'method' => 'post'
                ]
            ],
            [
                'controller' => new DeleteEntity($responseAdapter, $service),
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
                'controller' => new DeleteSet($responseAdapter, $service),
                'criteria' => [
                    'uri' => '/',
                    'method' => 'delete'
                ]
            ]
        ];
    }
}
