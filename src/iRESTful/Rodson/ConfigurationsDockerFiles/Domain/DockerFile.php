<?php
namespace iRESTful\Rodson\ConfigurationsDockerFiles\Domain;

interface DockerFile {
    public function getName();
    public function getMaintainer();
    public function getVersion();
    public function getRepositoryUrl();
}
