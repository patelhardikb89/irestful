{% autoescape false %}
{% import "includes/imports.class.php" as fn %}
<?php
namespace {{object.namespace.path}};
use {{object.interface.namespace.all}};

final class {{object.namespace.name}} implements {{object.interface.namespace.name}} {
    {{ fn.generateClassProperties(object.constructor.parameters) }}

    {{ fn.generateConstructorAnnotations(annotation) }}
    public function __construct({{- fn.generateConstructorSignature(object.constructor.parameters) }}) {
        {{ fn.generateAssignment(object.constructor.parameters) }}
    }

    {{ fn.generateGetters(object.constructor.parameters) }}
    {{ fn.generateCustomMethods(object.custom_methods) }}

}
{% endautoescape %}
