<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Applications;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Factories\ConcreteApplicationFactory;

final class ConcreteEntityApplication {

    public function __construct(array $server, array $queryParameters, array $requestParameters, $applicationConfigurationClassName, $objectConfigurationClassName) {
        $dbName = $this->retrieveDatabaseName($server['SERVER_NAME']);
        $configs = new $applicationConfigurationClassName($dbName, new $objectConfigurationClassName());
        $factory = new ConcreteApplicationFactory($configs->get());
        $factory->create()->execute([
            'uri' => strtok($server['REQUEST_URI'], '?'),
            'method' => $server['REQUEST_METHOD'],
            'port' => $server['SERVER_PORT'],
            'query_parameters' => $queryParameters,
            'request_parameters' => $requestParameters,
            'headers' => $this->getHeaders($server)
        ]);
    }

    private function getHeaders(array $data) {
        $headers = [];
        foreach($data as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }
        return $headers;
    }

    private function retrieveDatabaseName($serverName) {
        $exploded = explode('.', $serverName);
        return str_replace('-', '_', $exploded[0]);
    }

}
