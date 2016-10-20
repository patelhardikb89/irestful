<?php
namespace iRESTful\ConfigurationsNginx\Infrastructure\Objects;
use iRESTful\ConfigurationsNginx\Domain\Roots\Root;

final class ConcreteNginxRoot implements Root {
    private $fileName;
    private $directoryPath;
    public function __construct($fileName, array $directoryPath) {
        $this->fileName = $fileName;
        $this->directoryPath = $directoryPath;
    }

    public function getFileName() {
        return $this->fileName;
    }

    public function getDirectoryPath() {
        return $this->directoryPath;
    }

}
