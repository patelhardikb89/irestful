{% autoescape false %}
{% import "includes/imports.class.php" as fn %}
<?php
namespace {{object.namespace.path}};
use {{object.interface.namespace.all}};
{{ fn.generateUseInterfaces(object.constructor, object.custom_methods) }}

final class {{object.namespace.name}} implements {{object.interface.namespace.name}} {
    {{ fn.generateClassProperties(object.constructor.parameters) }}

    {{ fn.generateConstructorAnnotationParameters(parameters) }}
    public function __construct({{- fn.generateConstructorSignature(object.constructor.parameters) }}) {
        {{ fn.generateConstructorComboCustomMethod(object.constructor) }}
        {{ fn.generateAssignment(object.constructor.parameters) }}
    }

    {{ fn.generateGetters(object.constructor.parameters) }}

}
{% endautoescape %}
