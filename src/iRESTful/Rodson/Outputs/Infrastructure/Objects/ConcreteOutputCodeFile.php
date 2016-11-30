<?php
namespace iRESTful\Rodson\Outputs\Infrastructure\Objects;
use  iRESTful\Rodson\Outputs\Domain\Codes\Paths\Files\File;
use  iRESTful\Rodson\Outputs\Domain\Codes\Paths\Files\Exceptions\FileException;

final class ConcreteOutputCodeFile implements File {
    private $name;
    private $extension;
    public function __construct($name = null, $extension = null) {

        if (empty($extension)) {
            $extension = null;
        }

        if (empty($name)) {
            $name = null;
        }

        if (!empty($name) && !is_string($name)) {
            throw new FileException('The name must be a string if non-empty.');
        }

        if (!empty($extension) && !is_string($extension)) {
            throw new FileException('The extension must be a string if non-empty.');
        }

        $amount = (empty($name) ? 0 : 1) + (empty($extension) ? 0 : 1);
        if ($amount < 1) {
            throw new FileException('The file must, at least, contain a name or an extension.  '.$amount.' given.');
        }

        $this->name = $name;
        $this->extension = $extension;
    }

    public function hasName() {
        return !empty($this->name);
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
