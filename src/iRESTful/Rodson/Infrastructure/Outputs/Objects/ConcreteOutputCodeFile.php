<?php
namespace iRESTful\Rodson\Infrastructure\Outputs\Objects;
use iRESTful\Rodson\Domain\Outputs\Codes\Paths\Files\File;
use iRESTful\Rodson\Domain\Outputs\Codes\Paths\Files\Exceptions\FileException;

final class ConcreteOutputCodeFile implements File {
    private $name;
    private $extension;
    public function __construct($name, $extension = null) {

        if (empty($extension)) {
            $extension = null;
        }

        if (empty($name) || !is_string($name)) {
            throw new FileException('The name must be a non-empty string.');
        }

        if (!empty($extension) && !is_string($extension)) {
            throw new FileException('The extension must be a string if non-empty.');
        }

        $this->name = $name;
        $this->extension = $extension;
    }

    public function getName() {
        return $this->name;
    }

    public function hasExtension() {
        return !empty($this->extension);
    }

    public function getExtension() {
        return $this->extension;
    }

    public function get() {

        if (!$this->hasExtension()) {
            return $this->name;
        }

        return $this->name.'.'.$this->extension;
    }

}
