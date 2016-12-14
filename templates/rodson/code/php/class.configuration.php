{% autoescape false %}
<?php
namespace {{namespace.path}};
use {{object_configuration.namespace.all}};
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionObjectAdapterFactory;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Configurations\ConcreteEntityApplicationConfiguration;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Adapters\ConcreteJsonControllerResponseAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOServiceFactory;

{% for oneNamespace in controller_node.namespaces %}
    use {{oneNamespace.all}};
{% endfor %}

{% import "includes/imports.class.php" as fn %}
final class {{namespace.name}} {
    private $entityObjects;
    private $entityApplicationConfiguration;
    public function __construct() {
        $this->entityObjects = new {{object_configuration.namespace.name}}();
        $this->entityApplicationConfiguration = new ConcreteEntityApplicationConfiguration($this->entityObjects);
    }

    public function get() {
        $baseConfigs = $this->entityApplicationConfiguration->get();
        return array_merge_recursive($baseConfigs, [
            'rules' => $this->getControllerRules()
        ]);
    }

    private function getControllerRules() {

        {% if controller_node %}
            $serviceFactory = new PDOServiceFactory{
                return new $className(
                    $this->entityObjects->getTransformerObjects(),
                    $this->entityObjects->getContainerClassMapper(),
                    $this->entityObjects->getInterfaceClassMapper(),
                    $this->entityObjects->getDelimiter(),
                    $this->entityObjects->getTimezone(),
                    getenv('DB_DRIVER'),
                    getenv('DB_SERVER'),
                    getenv('DB_NAME'),
                    getenv('DB_USERNAME'),
                    getenv('DB_PASSWORD')
            );

            $service = $serviceFactory->create();
            $responseAdapter = new ConcreteJsonControllerResponseAdapter();

            return [
                {%- for oneController in controller_node.controllers -%}
                    [
                        'controller' => new {{oneController.controller.namespace.name}}($responseAdapter, $service),
                        'criteria' => [
                            'uri' => '{{oneController.pattern}}',
                            'method' => '{{oneController.method}}'
                        ]
                    ]{{- loop.last ? '' : ', ' -}}
                {%- endfor -%}
            ];
        {% else %}
            return [];
        {% endif %}
    }

}
{% endautoescape %}
