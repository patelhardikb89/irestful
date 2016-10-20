{% autoescape false %}
<?php
namespace {{namespace.path}};
use {{object_configuration.namespace.all}};
use iRESTful\Applications\Libraries\PDOEntities\Infrastructure\Adapters\PDOEntityRepositoryServiceAdapter;
use iRESTful\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionObjectAdapterFactory;


{% for oneNamespace in controller_node.namespaces %}
    use {{oneNamespace.all}};
{% endfor %}

{% import "includes/imports.class.php" as fn %}
final class {{namespace.name}} implements {{object_configuration.namespace.name}} {
    private $dbName;
    private $entityObjects;
    public function __construct($dbName) {
        $this->dbName = $dbName;
        $this->entityObjects = new {{object_configuration.namespace.name}}();
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

        {% for oneParameter in controller_node.parameters %}
            ${{oneParameter.parameter.name}} = $entityRepositoryServiceAdapter->fromClassNameToObject('{{oneParameter.parameter.type.namespace.all}}');
        {% endfor %}

        return [
            {%- for oneController in controller_node.controllers -%}
                [
                    'controller' => new {{oneController.controller.namespace.name}}({{- fn.generateConstructorInstanciationSignature(oneController.controller.constructor.parameters) -}}),
                    'criteria' => [
                        'uri' => '{{oneController.pattern}}',
                        'method' => '{{oneController.method}}'
                    ]
                ]
            {%- endfor -%}
        ];
    }

}
{% endautoescape %}
