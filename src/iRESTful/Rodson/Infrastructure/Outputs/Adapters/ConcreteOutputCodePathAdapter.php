<?php
namespace iRESTful\Rodson\Infrastructure\Outputs\Adapters;
use iRESTful\Rodson\Domain\Outputs\Codes\Paths\Adapters\PathAdapter;
use iRESTful\Rodson\Infrastructure\Outputs\Objects\ConcreteOutputCodePath;
use iRESTful\Rodson\Domain\Outputs\Codes\Paths\Files\Adapters\FileAdapter;
use iRESTful\Rodson\Domain\Outputs\Codes\Paths\Files\Exceptions\FileException;
use iRESTful\Rodson\Domain\Outputs\Codes\Paths\Exceptions\PathException;

final class ConcreteOutputCodePathAdapter implements PathAdapter {
    private $fileAdapter;
    private $basePath;
    public function __construct(FileAdapter $fileAdapter, array $basePath) {
        $this->fileAdapter = $fileAdapter;
        $this->basePath = $basePath;
    }

    public function fromRelativePathStringToPath($relativePath) {

        $exploded = explode('/', $relativePath);
        $fileName = array_pop($exploded);

        try {

            $file = $this->fileAdapter->fromFileStringToFile($fileName);
            return new ConcreteOutputCodePath($this->basePath, $exploded, $file);

        } catch (FileException $exception) {
            throw new PathException('There was an exception while converting a file name to a File object.', $exception);
        }

    }

}
