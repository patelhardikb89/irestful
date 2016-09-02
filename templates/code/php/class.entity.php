{% autoescape false %}
{% import "imports.class.php" as fn %}
<?php
namespace {{class.namespace.path}};
use {{class.interface.namespace.all}};
use iRESTful\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;
use iRESTful\Objects\Libraries\Ids\Domain\Uuids\Uuid;

{{ fn.generateClassAnnotations(annotation) }}
final class {{class.namespace.name}} extends AbstractEntity implements {{class.interface.namespace.name}} {

    {{ fn.generateConstructorAnnotations(annotation) }}
    public function __construct(Uuid $uuid, \DateTime $createdOn{{- fn.generateConstructorSignature(class.constructor.parameters, true) }}) {
        {{ fn.generateAssignment(class.constructor.parameters) }}
    }

    {{ fn.generateGetters(class.constructor.parameters) }}
    {{ fn.generateCustomMethods(class.custom_methods) }}

}
{% endautoescape %}
