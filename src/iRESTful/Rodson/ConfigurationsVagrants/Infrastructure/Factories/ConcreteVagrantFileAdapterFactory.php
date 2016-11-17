<?php
namespace iRESTful\Rodson\ConfigurationsVagrants\Infrastructure\Factories;
use iRESTful\Rodson\ConfigurationsVagrants\Domain\Adapters\Factories\VagrantFileAdapterFactory;
use iRESTful\Rodson\ConfigurationsVagrants\Infrastructure\Adapters\ConcreteVagrantFileAdapter;
use iRESTful\Rodson\ConfigurationsNginx\Infrastructure\Factories\ConcreteNginxAdapterFactory;

final class ConcreteVagrantFileAdapterFactory implements VagrantFileAdapterFactory {

    public function __construct() {

    }

    public function create() {

        $nginxAdapterFactory = new ConcreteNginxAdapterFactory();
        $nginxAdapter = $nginxAdapterFactory->create();

        return new ConcreteVagrantFileAdapter($nginxAdapter);
    }

}
