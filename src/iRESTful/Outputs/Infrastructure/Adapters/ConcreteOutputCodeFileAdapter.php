<?php
namespace iRESTful\Outputs\Infrastructure\Adapters;
use  iRESTful\Outputs\Domain\Codes\Paths\Files\Adapters\FileAdapter;
use iRESTful\Outputs\Infrastructure\Objects\ConcreteOutputCodeFile;

final class ConcreteOutputCodeFileAdapter implements FileAdapter {

    public function __construct() {

    }

    public function fromFileStringToFile($file) {

        if (strpos($file, '.') === false) {
            return new ConcreteOutputCodeFile($file);
        }

        $exploded = explode('.', $file);
        $extension = array_pop($exploded);
        $name = implode('.', $exploded);

        return new ConcreteOutputCodeFile($name, $extension);

    }

}
