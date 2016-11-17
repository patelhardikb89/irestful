{% autoescape false %}
{% import "includes/imports.class.php" as fn %}
<?php
namespace {{namespace.path}};
use {{configuration.object_configuration.namespace.all}};
use iRESTful\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRepositoryFactoryAdapter;
use iRESTful\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityServiceFactoryAdapter;
use iRESTful\SDK\HttpEntities\Infrastructure\Adapters\HttpEntitySetServiceFactoryAdapter;
use iRESTful\Objects\Entities\Entities\Infrastructure\Adapters\ReflectionEntityAdapterAdapterFactoryAdapter;
use iRESTful\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRelationRepositoryFactoryAdapter;
use iRESTful\Objects\Entities\Entities\Infrastructure\Factories\ConcreteEntityAdapterFactory;

final class {{namespace.name}} extends \PHPUnit_Framework_TestCase {
    private $data;
    private $entityRepositoryFactory;
    private $entityServiceFactory;
    private $entitySetServiceFactory;
    private $entityAdapterFactory;
    public function setUp() {
        
        $objectConfigurations = new {{configuration.object_configuration.namespace.name}}();
        $params = [
            'transformer_objects' => $objectConfigurations->getTransformerObjects(),
            'container_class_mapper' => $objectConfigurations->getContainerClassMapper(),
            'interface_class_mapper' => $objectConfigurations->getInterfaceClassMapper(),
            'delimiter' => $objectConfigurations->getDelimiter(),
            'base_url' => getenv('API_PROTOCOL').'://'.getenv('API_DOMAIN'),
            'port' => getenv('API_PORT')
        ];

        $entityRepositoryFactoryAdapter = new HttpEntityRepositoryFactoryAdapter();
        $this->entityRepositoryFactory = $entityRepositoryFactoryAdapter->fromDataToEntityRepositoryFactory($params);

        $entityRelationRepositoryFactoryAdapter = new HttpEntityRelationRepositoryFactoryAdapter();
        $entityRelationRepository = $entityRelationRepositoryFactoryAdapter->fromDataToEntityRelationRepositoryFactory($params)->create();

        $entityServiceFactoryAdapter = new HttpEntityServiceFactoryAdapter();
        $this->entityServiceFactory = $entityServiceFactoryAdapter->fromDataToEntityServiceFactory($params);

        $entitySetServiceFactoryAdapter = new HttpEntitySetServiceFactoryAdapter();
        $this->entitySetServiceFactory = $entitySetServiceFactoryAdapter->fromDataToEntitySetServiceFactory($params);

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


    {%- if custom_method_nodes|length > 0 -%}
        {% for oneCustomMethodNode in custom_method_nodes %}

            {{ fn.generateCustomMethods(oneCustomMethodNode.related_custom_methods) }}
            {{ fn.generateCustomMethods(oneCustomMethodNode.custom_methods) }}
        {% endfor -%}
    {%- endif -%}

}
{% endautoescape %}
