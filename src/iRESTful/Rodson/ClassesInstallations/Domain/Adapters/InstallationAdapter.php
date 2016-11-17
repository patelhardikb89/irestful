<?php
namespace iRESTful\Rodson\ClassesInstallations\Domain\Adapters;

interface InstallationAdapter {
    public function fromDataToInstallation(array $data);
}
