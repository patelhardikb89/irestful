<?php
namespace iRESTful\Rodson\ConfigurationsDockerFiles\Infrastructure\Adapters;
use iRESTful\Rodson\ConfigurationsDockerFiles\Domain\Adapters\DockerFileAdapter;
use iRESTful\Rodson\DSLs\Domain\DSL;
use iRESTful\Rodson\ConfigurationsDockerFiles\Infrastructure\Objects\ConcreteDockerFile;

final class ConcreteDockerFileAdapter implements DockerFileAdapter {

    public function __construct() {

    }

    public function fromDSLToDockerFile(DSL $dsl) {
        
        $name = $dsl->getName();
        $maintainer = $dsl->getMaintainer();
        $version = $dsl->getVersion();
        $urls = $dsl->getUrls();
        $repositoryUrl = (isset($urls['repository'])) ? $urls['repository'] : null;

        return new ConcreteDockerFile($name, $maintainer, $version, $repositoryUrl);

    }

}
