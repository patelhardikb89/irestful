{% autoescape false %}
<?php
namespace {{namespace.path}};
use iRESTful\Objects\Entities\Entities\Configurations\EntityConfiguration;

{% import "includes/returned.hashmap.php" as returned %}
final class {{namespace.name}} implements EntityConfiguration {

    public function __construct() {

    }

    public function getDelimiter() {
        return '{{delimiter}}';
    }

    public function getTimezone() {
        return '{{timezone}}';
    }

    public function getContainerClassMapper() {
        return [
            {{- returned.returnedHashMap(mappers.containers) -}}
        ];
    }

    public function getInterfaceClassMapper() {
        return [
            {{- returned.returnedHashMap(mappers.interfaces.objects) -}}
        ];
    }

    public function getTransformerObjects() {
        return [
            {{- returned.hashMapInstanceLine('iRESTful\Objects\Libraries\Dates\Domain\Adapters\DateTimeAdapter', '\iRESTful\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteDateTimeAdapter', '$this->getTimezone()') -}}
            {{- returned.hashMapInstanceLine('iRESTful\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter', '\iRESTful\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter') -}}
            {{- returned.returnedHashMapObjects(mappers.interfaces.adapters) -}}
        ];
    }

}
{% endautoescape %}
