<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Outputs\Codes\Paths\Files\Adapters\FileAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteOutputCodeFile;

final class ConcreteOutputCodeFileAdapter implements FileAdapter {

    public function __construct() {

    }

    public function fromFileStringToFile($file) {

        $exploded = explode('.', $file);
        $extension = array_pop($exploded);
        $name = implode('.', $exploded);

        return new ConcreteOutputCodeFile($name, $extension);

    }

}
