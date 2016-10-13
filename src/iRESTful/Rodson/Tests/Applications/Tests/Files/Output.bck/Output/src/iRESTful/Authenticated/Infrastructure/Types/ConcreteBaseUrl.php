<?php
namespace iRESTful\Authenticated\Infrastructure\Types;
use iRESTful\Authenticated\Domain\Types\BaseUrls\BaseUrl;


final class ConcreteBaseUrl implements BaseUrl {
    private $baseUrl;
    public function __construct($baseUrl) {
        $this->baseUrl = $baseUrl;
    }
    
    public function get() {
        return $this->baseUrl;
    }
    
}
