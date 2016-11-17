<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Adapters\DomainNameAdapterInterface;

final class DomainNameAdapter implements DomainNameAdapterInterface {

    public function __construct() {

    }

    public function fromDomainNamesToString(array $domainNames) {

        foreach($domainNames as $oneDomainName) {
            if (!is_string($oneDomainName)) {
                throw new \Exception('TEST');
            }
        }

        return implode(';', $domainNames);
    }

    public function fromStringToDomainNames($string) {

        if (!is_string($string)) {
            throw new \Exception('TEST');
        }

        return explode(';', $string);
    }

}
