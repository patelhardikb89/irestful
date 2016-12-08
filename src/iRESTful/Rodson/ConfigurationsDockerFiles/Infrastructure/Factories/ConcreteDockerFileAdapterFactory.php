<?php
namespace iRESTful\Rodson\ConfigurationsDockerFiles\Infrastructure\Factories;
use iRESTful\Rodson\ConfigurationsDockerFiles\Domain\Adapters\Factories\DockerFileAdapterFactory;
use iRESTful\Rodson\ConfigurationsDockerFiles\Infrastructure\Adapters\ConcreteDockerFileAdapter;

final class ConcreteDockerFileAdapterFactory implements DockerFileAdapterFactory {

    public function __construct() {

    }

    public function create() {
        return new ConcreteDockerFileAdapter();
    }

}
