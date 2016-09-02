{% autoescape false %}
{% import "imports.class.php" as fn %}
<?php
namespace {{class.namespace.path}};
use {{class.interface.namespace.all}};

final class {{class.namespace.name}} implements {{class.interface.namespace.name}} {

    {{ fn.generateConstructorAnnotations(annotation) }}
    public function __construct({{- fn.generateConstructorSignature(class.constructor.parameters) }}) {
        {{ fn.generateAssignment(class.constructor.parameters) }}
    }

    {{ fn.generateGetters(class.constructor.parameters) }}
    {{ fn.generateCustomMethods(class.custom_methods) }}

}
{% endautoescape %}
