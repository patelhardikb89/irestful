{% autoescape false %}
{% import "includes/imports.class.php" as fn %}
<?php
namespace {{namespace.path}};
use iRESTful\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRepositoryFactoryAdapter;
use iRESTful\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityServiceFactoryAdapter;
use iRESTful\Objects\Entities\Entities\Infrastructure\Adapters\ReflectionEntityAdapterAdapterFactoryAdapter;
use iRESTful\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRelationRepositoryFactoryAdapter;
use iRESTful\Objects\Entities\Entities\Infrastructure\Factories\ConcreteEntityAdapterFactory;

final class {{namespace.name}} extends \PHPUnit_Framework_TestCase {

    public function setUp() {

        $entityRepositoryFactoryAdapter = new HttpEntityRepositoryFactoryAdapter();
        $this->entityRepositoryFactory = $entityRepositoryFactoryAdapter->fromDataToEntityRepositoryFactory($params);

        $entityRelationRepositoryFactoryAdapter = new HttpEntityRelationRepositoryFactoryAdapter();
        $entityRelationRepository = $entityRelationRepositoryFactoryAdapter->fromDataToEntityRelationRepositoryFactory($params)->create();

        $entityServiceFactoryAdapter = new HttpEntityServiceFactoryAdapter();
        $this->entityServiceFactory = $entityServiceFactoryAdapter->fromDataToEntityServiceFactory($params);

        $entityAdapterAdapterFactoryAdapter = new ReflectionEntityAdapterAdapterFactoryAdapter();
        $entityAdapterAdapter = $entityAdapterAdapterFactoryAdapter->fromDataToEntityAdapterAdapterFactory($params)->create();
        $this->entityAdapterFactory = new ConcreteEntityAdapterFactory(
            $this->entityRepositoryFactory->create(),
            $entityRelationRepository,
            $entityAdapterAdapter
        );

        $this->init();
    }

    public function tearDown() {
        $this->entityRepositoryFactory = null;
        $this->entityServiceFactory = null;
        $this->entityAdapterFactory = null;
    }

    {{ fn.generateCustomMethods(custom_methods) }}
}
{% endautoescape %}
