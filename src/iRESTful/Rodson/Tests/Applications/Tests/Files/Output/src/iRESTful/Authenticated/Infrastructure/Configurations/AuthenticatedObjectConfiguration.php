<?php
namespace iRESTful\Authenticated\Infrastructure\Configurations;
use iRESTful\Objects\Entities\Entities\Configurations\EntityConfiguration;

final class AuthenticatedObjectConfiguration implements EntityConfiguration {

    public function __construct() {

    }

    public function getDelimiter() {
        return '___';
    }

    public function getTimezone() {
        return 'America/Montreal';
    }

    public function getContainerClassMapper() {
        return [                        'endpoint' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteEndpoint',
    'api' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteApi',
    'params' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteParams',
    'registration' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteRegistration',
    'resource' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteResource',
    'shared_resource' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteSharedResource',
    'owner' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteOwner',
    'software' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteSoftware',
    'user' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteUser',
    'role' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteRole',
    'permission' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcretePermission'
    ];
    }

    public function getInterfaceClassMapper() {
        return [                        'iRESTful\Authenticated\Domain\Entities\Endpoint' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteEndpoint',
    'iRESTful\Authenticated\Domain\Entities\Api' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteApi',
    'iRESTful\Authenticated\Domain\Entities\Params' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteParams',
    'iRESTful\Authenticated\Domain\Entities\Registration' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteRegistration',
    'iRESTful\Authenticated\Domain\Entities\Resource' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteResource',
    'iRESTful\Authenticated\Domain\Entities\SharedResource' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteSharedResource',
    'iRESTful\Authenticated\Domain\Entities\Owner' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteOwner',
    'iRESTful\Authenticated\Domain\Entities\Software' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteSoftware',
    'iRESTful\Authenticated\Domain\Entities\User' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteUser',
    'iRESTful\Authenticated\Domain\Entities\Role' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcreteRole',
    'iRESTful\Authenticated\Domain\Entities\Permission' => 'iRESTful\Authenticated\Infrastructure\Entities\ConcretePermission',
    'iRESTful\Authenticated\Domain\Objects\Pattern' => 'iRESTful\Authenticated\Infrastructure\Objects\ConcretePattern',
    'iRESTful\Authenticated\Domain\Objects\ParamPattern' => 'iRESTful\Authenticated\Infrastructure\Objects\ConcreteParamPattern',
    'iRESTful\Authenticated\Domain\Objects\Credentials' => 'iRESTful\Authenticated\Infrastructure\Objects\ConcreteCredentials',
    'iRESTful\Authenticated\Domain\Types\BaseUrls\BaseUrl' => 'iRESTful\Authenticated\Infrastructure\Types\ConcreteBaseUrl',
    'iRESTful\Authenticated\Domain\Types\Keynames\Keyname' => 'iRESTful\Authenticated\Infrastructure\Types\ConcreteKeyname',
    'iRESTful\Authenticated\Domain\Types\Uris\Uri' => 'iRESTful\Authenticated\Infrastructure\Types\ConcreteUri',
    'iRESTful\Authenticated\Domain\Types\StringNumerics\StringNumeric' => 'iRESTful\Authenticated\Infrastructure\Types\ConcreteStringNumeric'
    ];
    }

    public function getTransformerObjects() {
        return [    'iRESTful\Objects\Libraries\Dates\Domain\Adapters\DateTimeAdapter' => new \iRESTful\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteDateTimeAdapter($this->getTimezone()),
    'iRESTful\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter' => new \iRESTful\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter(),
                        'iRESTful\Authenticated\Domain\Types\BaseUrls\Adapters\BaseUrlAdapter' => new \iRESTful\Authenticated\Infrastructure\Types\Adapters\ConcreteBaseUrlAdapter(),
    'iRESTful\Authenticated\Domain\Types\Keynames\Adapters\KeynameAdapter' => new \iRESTful\Authenticated\Infrastructure\Types\Adapters\ConcreteKeynameAdapter(),
    'iRESTful\Authenticated\Domain\Types\Uris\Adapters\UriAdapter' => new \iRESTful\Authenticated\Infrastructure\Types\Adapters\ConcreteUriAdapter(),
    'iRESTful\Authenticated\Domain\Types\StringNumerics\Adapters\StringNumericAdapter' => new \iRESTful\Authenticated\Infrastructure\Types\Adapters\ConcreteStringNumericAdapter()
    ];
    }

}
