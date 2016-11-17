{% autoescape false %}
<?php
namespace {{namespace.path}};
use {{object_configuration.namespace.all}};
use iRESTful\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionObjectAdapterFactory;
use iRESTful\Applications\APIs\Entities\Infrastructure\Configurations\ConcreteEntityApplicationConfiguration;

{% for oneNamespace in controller_node.namespaces %}
    use {{oneNamespace.all}};
{% endfor %}

{% import "includes/imports.class.php" as fn %}
final class {{namespace.name}} {
    private $dbName;
    private $entityObjects;
    private $entityApplicationConfiguration;
    public function __construct($dbName) {
        $this->dbName = $dbName;
        $this->entityObjects = new {{object_configuration.namespace.name}}();
        $this->entityApplicationConfiguration = new ConcreteEntityApplicationConfiguration($dbName, $this->entityObjects);
    }

    public function get() {
        $baseConfigs = $this->entityApplicationConfiguration->get();
        return array_merge_recursive($baseConfigs, [
            'rules' => $this->getControllerRules()
        ]);
    }

    private function getControllerRules() {

        {% if controller_node %}
            $factory = function($className) {
                return new $className(
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
            };

            {% for oneParameter in controller_node.parameters %}
                ${{oneParameter.constructor_parameter.parameter.name}} = $factory('\{{oneParameter.class_namespace.all}}');
            {% endfor %}

            return [
                {%- for oneController in controller_node.controllers -%}
                    [
                        'controller' => new {{oneController.controller.namespace.name}}({{- fn.generateConstructorInstanciationSignature(oneController.controller.constructor.parameters) -}}),
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
