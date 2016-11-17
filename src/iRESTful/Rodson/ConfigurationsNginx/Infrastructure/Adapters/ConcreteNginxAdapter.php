<?php
namespace iRESTful\Rodson\ConfigurationsNginx\Infrastructure\Adapters;
use iRESTful\Rodson\ConfigurationsNginx\Domain\Adapters\NginxAdapter;
use iRESTful\Rodson\ConfigurationsNginx\Domain\Roots\Adapters\RootAdapter;
use iRESTful\Rodson\ConfigurationsNginx\Infrastructure\Objects\ConcreteNginx;
use iRESTful\Rodson\ConfigurationsNginx\Domain\Exceptions\NginxException;

final class ConcreteNginxAdapter implements NginxAdapter {
    private $rootAdapter;
    public function __construct(RootAdapter $rootAdapter) {
        $this->rootAdapter = $rootAdapter;
    }

    public function fromDataToNginx(array $data) {

        if (!isset($data['name'])) {
            throw new NginxException('The name keyname is mandatory in order to convert data to an Nginx object.');
        }

        if (!isset($data['server_name'])) {
            throw new NginxException('The server_name keyname is mandatory in order to convert data to an Nginx object.');
        }

        if (!isset($data['root'])) {
            throw new NginxException('The root keyname is mandatory in order to convert data to an Nginx object.');
        }

        $root = $this->rootAdapter->fromDataToRoot($data['root']);
        return new ConcreteNginx($data['name'].'.conf', $data['server_name'], $root);
    }

}
