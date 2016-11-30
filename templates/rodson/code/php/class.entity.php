{% autoescape false %}
{% import "includes/imports.class.php" as fn %}
<?php
namespace {{entity.namespace.path}};
use {{entity.interface.namespace.all}};
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;
{{ fn.generateUseInterfaces(entity.constructor, entity.custom_methods) }}

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
