{% autoescape false %}
{% import "includes/imports.class.php" as fn %}
<?php
namespace {{namespace.path}};
use {{interface.namespace.all}};

final class {{namespace.name}} implements {{interface.namespace.name}} {
    {{ fn.generateClassProperties(constructor.parameters) }}

    public function __construct({{- fn.generateConstructorSignature(constructor.parameters) }}) {
        {{ fn.generateAssignment(constructor.parameters) }}
    }

    {% for oneMethod in methods %}
        public function {{oneMethod.name}}(${{oneMethod.parameter.name}}) {
            return new \{{oneMethod.namespace.all}}(${{oneMethod.parameter.name}});
        }
    {% endfor %}

}
{% endautoescape %}
