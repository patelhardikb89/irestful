<?php
namespace iRESTful\Rodson\ConfigurationsNginx\Infrastructure\Factories;
use iRESTful\Rodson\ConfigurationsNginx\Domain\Adapters\Factories\NginxAdapterFactory;
use iRESTful\Rodson\ConfigurationsNginx\Infrastructure\Adapters\ConcreteNginxRootAdapter;
use iRESTful\Rodson\ConfigurationsNginx\Infrastructure\Adapters\ConcreteNginxAdapter;

final class ConcreteNginxAdapterFactory implements NginxAdapterFactory {

    public function __construct() {

    }

    public function create() {

        $rootAdapter = new ConcreteNginxRootAdapter();
        return new ConcreteNginxAdapter($rootAdapter);
    }

}
