<?php
namespace iRESTful\ConfigurationsVagrants\Infrastructure\Factories;
use iRESTful\ConfigurationsVagrants\Domain\Adapters\Factories\VagrantFileAdapterFactory;
use iRESTful\ConfigurationsVagrants\Infrastructure\Adapters\ConcreteVagrantFileAdapter;
use iRESTful\ConfigurationsNginx\Infrastructure\Factories\ConcreteNginxAdapterFactory;

final class ConcreteVagrantFileAdapterFactory implements VagrantFileAdapterFactory {

    public function __construct() {

    }

    public function create() {

        $nginxAdapterFactory = new ConcreteNginxAdapterFactory();
        $nginxAdapter = $nginxAdapterFactory->create();

        return new ConcreteVagrantFileAdapter($nginxAdapter);
    }

}
