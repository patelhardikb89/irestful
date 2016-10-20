<?php
namespace iRESTful\ConfigurationsNginx\Infrastructure\Factories;
use iRESTful\ConfigurationsNginx\Domain\Adapters\Factories\NginxAdapterFactory;
use iRESTful\ConfigurationsNginx\Infrastructure\Adapters\ConcreteNginxRootAdapter;
use iRESTful\ConfigurationsNginx\Infrastructure\Adapters\ConcreteNginxAdapter;

final class ConcreteNginxAdapterFactory implements NginxAdapterFactory {

    public function __construct() {

    }

    public function create() {

        $rootAdapter = new ConcreteNginxRootAdapter();
        return new ConcreteNginxAdapter($rootAdapter);
    }

}
