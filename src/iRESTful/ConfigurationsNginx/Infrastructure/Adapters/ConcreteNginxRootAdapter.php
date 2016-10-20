<?php
namespace iRESTful\ConfigurationsNginx\Infrastructure\Adapters;
use iRESTful\ConfigurationsNginx\Domain\Roots\Adapters\RootAdapter;
use iRESTful\ConfigurationsNginx\Infrastructure\Objects\ConcreteNginxRoot;
use iRESTful\ConfigurationsNginx\Domain\Roots\Exceptions\RootException;

final class ConcreteNginxRootAdapter implements RootAdapter {

    public function __construct() {

    }

    public function fromDataToRoot(array $data) {

        if (!isset($data['file_name'])) {
            throw new RootException('The file_name keyname is mandatory in order to convert data to a Root object.');
        }

        if (!isset($data['directory_path'])) {
            throw new RootException('The directory_path keyname is mandatory in order to convert data to a Root object.');
        }

        $directoryPath = array_filter(explode('/', $data['directory_path']));
        return new ConcreteNginxRoot($data['file_name'], $directoryPath);

    }

}
