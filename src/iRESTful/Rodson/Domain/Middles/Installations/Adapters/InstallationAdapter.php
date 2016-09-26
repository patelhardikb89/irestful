<?php
namespace iRESTful\Rodson\Domain\Middles\Installations\Adapters;

interface InstallationAdapter {
    public function fromDataToInstallation(array $data);
}
