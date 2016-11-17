{% autoescape false %}
{% import "includes/imports.class.php" as fn %}
<?php
namespace {{namespace.path}};

interface {{namespace.name}} {
    {% for oneMethod in methods %}
        {% if oneMethod.parameters|length > 0 %}
            public function {{oneMethod.name}}({{- fn.generateSignature(oneMethod.parameters) -}});
        {% else %}
            public function {{oneMethod.name}}();
        {% endif %}

    {% endfor %}
}
{% endautoescape %}
