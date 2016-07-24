<?php
namespace iRESTful\Rodson\Infrastructure\Outputs\Factories;
use iRESTful\Rodson\Domain\Outputs\Codes\Adapters\Factories\CodeAdapterFactory;
use iRESTful\Rodson\Infrastructure\Outputs\Adapters\PHPCodeAdapter;
use iRESTful\Rodson\Infrastructure\Outputs\Adapters\ConcreteOutputCodePathAdapter;
use iRESTful\Rodson\Infrastructure\Outputs\Adapters\ConcreteOutputCodeFileAdapter;

final class PHPCodeAdapterFactory implements CodeAdapterFactory {
    private $basePath;
    public function __construct(array $basePath) {
        $this->basePath = $basePath;
    }

    public function create() {

        $fileAdapter = new ConcreteOutputCodeFileAdapter();
        $pathAdapter = new ConcreteOutputCodePathAdapter($fileAdapter, $this->basePath);
        return new PHPCodeAdapter($pathAdapter);
    }

}
