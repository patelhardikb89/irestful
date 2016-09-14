{% autoescape false %}
{% import "includes/imports.class.php" as fn %}
<?php
namespace {{entity.namespace.path}};
use {{entity.interface.namespace.all}};
use iRESTful\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;
use iRESTful\Objects\Libraries\Ids\Domain\Uuids\Uuid;

{% for oneParameter in entity.constructor.parameters %}
    {% if oneParameter.parameter.type.namespace.all %}
        use {{oneParameter.parameter.type.namespace.all}};
    {% endif %}
{% endfor %}

{{ fn.generateClassAnnotations(annotation) }}
final class {{entity.namespace.name}} extends AbstractEntity implements {{entity.interface.namespace.name}} {
    {{ fn.generateClassProperties(entity.constructor.parameters) }}

    {{ fn.generateConstructorAnnotationParameters(annotation.parameters) }}
    public function __construct(Uuid $uuid, \DateTime $createdOn{{- fn.generateConstructorSignature(entity.constructor.parameters, true) }}) {
        parent::__construct($uuid, $createdOn);
        {{ fn.generateAssignment(entity.constructor.parameters) }}
    }

    {{ fn.generateGetters(entity.constructor.parameters) }}
    {{ fn.generateCustomMethods(entity.custom_methods) }}

}
{% endautoescape %}
