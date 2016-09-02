{% autoescape false %}
{% import "imports.class.php" as fn %}
<?php
namespace {{class.namespace.path}};
use {{class.interface.namespace.all}};

final class {{class.namespace.name}} implements {{class.interface.namespace.name}} {

    public function __construct({{- fn.generateConstructorSignature(class.constructor.parameters, true) }}) {
        {{ fn.generateAssignment(class.constructor.parameters) }}
    }

}
{% endautoescape %}
