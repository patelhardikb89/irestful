<?php
namespace iRESTful\Rodson\ConfigurationsNginx\Infrastructure\Objects;
use iRESTful\Rodson\ConfigurationsNginx\Domain\Roots\Root;

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
