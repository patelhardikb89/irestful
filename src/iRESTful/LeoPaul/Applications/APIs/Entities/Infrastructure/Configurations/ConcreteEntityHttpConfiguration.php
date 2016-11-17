<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Configurations;
use iRESTful\LeoPaul\Applications\APIs\Entities\Domain\Configurations\EntityHttpConfiguration;
use iRESTful\LeoPaul\Objects\Entities\Entities\Configurations\EntityConfiguration;

final class ConcreteEntityHttpConfiguration implements EntityHttpConfiguration {
    private $apiUrl;
    private $entityObjects;
    public function __construct($apiProtocol, $apiDomain, EntityConfiguration $configuration) {
        $this->apiUrl = $apiProtocol.'://'.$apiDomain;
        $this->entityObjects = $configuration;
    }

    public function get() {
        return [
            'transformer_objects' => $this->entityObjects->getTransformerObjects(),
            'container_class_mapper' => $this->entityObjects->getContainerClassMapper(),
            'interface_class_mapper' => $this->entityObjects->getInterfaceClassMapper(),
            'delimiter' => $this->entityObjects->getDelimiter(),
            'base_url' => $this->apiUrl,
            'port' => getenv('API_PORT')
        ];
    }

}
