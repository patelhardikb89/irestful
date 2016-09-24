{% autoescape false %}
{% import "includes/imports.class.php" as fn %}
<?php
namespace {{namespace.path}};
use iRESTful\Applications\Libraries\Routers\Domain\Controllers\Controller;

{% for oneParameter in constructor.parameters %}
    {% if oneParameter.parameter.type.namespace.all %}
        use {{oneParameter.parameter.type.namespace.all}};
    {% endif %}
{% endfor %}

final class {{namespace.name}} implements Controller {

    public function __construct({{- fn.generateConstructorSignature(constructor.parameters) }}) {
        {{ fn.generateAssignment(constructor.parameters) }}
    }

    {{ fn.generateCustomMethod(custom_method) }}

}
{% endautoescape %}
