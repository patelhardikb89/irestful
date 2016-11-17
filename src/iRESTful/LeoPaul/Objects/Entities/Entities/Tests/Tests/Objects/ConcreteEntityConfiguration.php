<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Configurations\EntityConfiguration;

final class ConcreteEntityConfiguration implements EntityConfiguration {

    public function __construct() {

    }

    public function getDelimiter() {
        return '___';
    }

    public function getTimezone() {
        return 'America/Montreal';
    }

    public function getContainerClassMapper() {
        return [
            'simple_entity' => 'iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Objects\ConcreteSimpleEntity'
        ];
    }

    public function getInterfaceClassMapper() {
        return [
            'iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Objects\SimpleEntity' => 'iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Objects\ConcreteSimpleEntity'
        ];
    }

    public function getTransformerObjects() {
        return [
            'iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter' => new \iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter(),
            'iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Adapters\DateTimeAdapter' => new \iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteDateTimeAdapter($this->getTimezone())
        ];
    }

}
