<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Configurations\EntityConfiguration;

final class ConcreteEntityObjectsConfiguration implements EntityConfiguration {

    public function __construct() {

    }

    public function getTimezone() {
        return 'America/Montreal';
    }

    public function getDelimiter() {
        return '___';
    }

    public function getContainerClassMapper() {
        return [
            'simple_entity' => 'iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects\SimpleEntity',
            'complex_entity' => 'iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects\ComplexEntity'
        ];
    }

    public function getInterfaceClassMapper() {
        return [
            'iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects\SimpleEntityInterface' => 'iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects\SimpleEntity',
            'iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects\ComplexEntityInterface' => 'iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects\ComplexEntity'
        ];
    }

    public function getTransformerObjects() {
        return [
            'iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter' => new \iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter(),
            'iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Adapters\DateTimeAdapter' => new \iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteDateTimeAdapter($this->getTimezone())
        ];
    }

}
