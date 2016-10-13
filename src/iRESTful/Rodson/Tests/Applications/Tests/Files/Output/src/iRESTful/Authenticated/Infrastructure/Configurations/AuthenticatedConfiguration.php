<?php
namespace iRESTful\Authenticated\Infrastructure\Configurations;
use iRESTful\Authenticated\Infrastructure\Configurations\AuthenticatedObjectConfiguration;
use iRESTful\Applications\Libraries\PDOEntities\Infrastructure\Adapters\PDOEntityRepositoryServiceAdapter;
use iRESTful\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionObjectAdapterFactory;


    use iRESTful\Authenticated\Infrastructure\Controllers\ConcreteRetrieveByUuid;
    use iRESTful\Objects\Entities\Entities\Domain\Repositories\Factories\EntityRepositoryFactory;
    use iRESTful\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
    use iRESTful\Authenticated\Infrastructure\Controllers\ConcreteRetrievePartialSet;
    use iRESTful\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Factories\EntityPartialSetRepositoryFactory;
    use iRESTful\Authenticated\Infrastructure\Controllers\ConcreteRetrieveSet;
    use iRESTful\Objects\Entities\Entities\Domain\Sets\Repositories\Factories\EntitySetRepositoryFactory;
    use iRESTful\Authenticated\Infrastructure\Controllers\ConcreteRetrieveByKeyname;

final class AuthenticatedConfiguration implements AuthenticatedObjectConfiguration {
    private $dbName;
    private $entityObjects;
    public function __construct($dbName) {
        $this->dbName = $dbName;
        $this->entityObjects = new AuthenticatedObjectConfiguration();
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

                    $entityRepositoryFactory = $entityRepositoryServiceAdapter->fromClassNameToObject('iRESTful\Objects\Entities\Entities\Domain\Repositories\Factories\EntityRepositoryFactory');
                    $entityAdapterFactory = $entityRepositoryServiceAdapter->fromClassNameToObject('iRESTful\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory');
                    $entityPartialSetRepositoryFactory = $entityRepositoryServiceAdapter->fromClassNameToObject('iRESTful\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Factories\EntityPartialSetRepositoryFactory');
                    $entitySetRepositoryFactory = $entityRepositoryServiceAdapter->fromClassNameToObject('iRESTful\Objects\Entities\Entities\Domain\Sets\Repositories\Factories\EntitySetRepositoryFactory');
        
        return [[
                    'controller' => new ConcreteRetrieveByUuid($entityRepositoryFactory, $entityAdapterFactory),
                    'criteria' => [
                        'uri' => '/$container$/$[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}|uuid$',
                        'method' => 'get'
                    ]
                ][
                    'controller' => new ConcreteRetrievePartialSet($entityPartialSetRepositoryFactory, $entityAdapterFactory),
                    'criteria' => [
                        'uri' => '/$container$/partials',
                        'method' => 'get'
                    ]
                ][
                    'controller' => new ConcreteRetrieveSet($entitySetRepositoryFactory, $entityAdapterFactory),
                    'criteria' => [
                        'uri' => '/$container$',
                        'method' => 'get'
                    ]
                ][
                    'controller' => new ConcreteRetrieveByKeyname($entityRepositoryFactory, $entityAdapterFactory),
                    'criteria' => [
                        'uri' => '/$container$/$name$/$value',
                        'method' => 'get'
                    ]
                ]];
    }

}
