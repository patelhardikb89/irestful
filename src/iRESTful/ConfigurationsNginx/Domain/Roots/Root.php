<?php
namespace iRESTful\ConfigurationsNginx\Domain\Roots;

interface Root {
    public function getFileName();
    public function getDirectoryPath();
}
