<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Adapters;

interface DomainNameAdapterInterface {
    public function fromDomainNamesToString(array $domainNames);
    public function fromStringToDomainNames($string);
}
