<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Outputs\Codes\Paths\Files\File;
use iRESTful\Rodson\Domain\Outputs\Codes\Paths\Files\Exceptions\FileException;

final class ConcreteOutputCodeFile implements File {
    private $name;
    private $extension;
    public function __construct($name, $extension) {

        if (empty($name) || !is_string($name)) {
            throw new FileException('The name must be a non-empty string.');
        }

        if (empty($extension) || !is_string($extension)) {
            throw new FileException('The extension must be a non-empty string.');
        }

        $this->name = $name;
        $this->extension = $extension;
    }

    public function getName() {
        return $this->name;
    }

    public function getExtension() {
        return $this->extension;
    }

    public function get() {
        return $this->name.'.'.$this->extension;
    }

}
