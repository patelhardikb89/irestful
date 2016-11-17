<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Libraries\Https\Applications\Factories\HttpApplicationFactory;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Applications\CurlHttpApplication;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Adapters\ConcreteHttpRequestAdapter;

final class CurlHttpApplicationFactory implements HttpApplicationFactory {
    private $baseUrl;
    public function __construct($baseUrl) {
        $this->baseUrl = $baseUrl;
    }

    public function create() {
        $httpRequestAdapter = new ConcreteHttpRequestAdapter();
        return new CurlHttpApplication($httpRequestAdapter, $this->baseUrl);
    }

}
