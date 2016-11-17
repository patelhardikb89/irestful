<?php
namespace iRESTful\Rodson\Outputs\Infrastructure\Objects;
use  iRESTful\Rodson\Outputs\Domain\Codes\Paths\Path;
use  iRESTful\Rodson\Outputs\Domain\Codes\Paths\Files\File;
use  iRESTful\Rodson\Outputs\Domain\Codes\Paths\Exceptions\PathException;

final class ConcreteOutputCodePath implements Path {
    private $basePath;
    private $relativePath;
    private $file;
    public function __construct(array $basePath, array $relativePath, File $file) {

        if (empty($basePath)) {
            throw new PathException('The basePath cannot be empty.');
        }

        if (!empty($relativePath)) {
            foreach($relativePath as $oneFolder) {

                if (empty($oneFolder) || !is_string($oneFolder)) {
                    throw new PathException('The relativePath array must only contain strings.');
                }

            }
        }

        foreach($basePath as $oneFolder) {

            if (empty($oneFolder) || !is_string($oneFolder)) {
                throw new PathException('The basePath array must only contain strings.');
            }

        }

        $this->basePath = $basePath;
        $this->relativePath = $relativePath;
        $this->file = $file;
    }

    public function getPath() {
        return array_merge($this->basePath, $this->relativePath, [$this->file->get()]);
    }

    public function getAbsolutePath() {
        return array_merge($this->basePath, $this->relativePath);
    }

    public function getRelativePath() {
        return $this->relativePath;
    }

    public function getFile() {
        return $this->file;
    }

}
