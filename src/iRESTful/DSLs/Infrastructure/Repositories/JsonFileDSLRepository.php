<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Repositories;
use iRESTful\DSLs\Domain\Repositories\DSLRepository;
use iRESTful\DSLs\Domain\Adapters\Factories\DSLAdapterFactory;
use iRESTful\DSLs\Domain\Exceptions\DSLException;

final class JsonFileDSLRepository implements DSLRepository {
    private $dslAdapterFactory;
    public function __construct(DSLAdapterFactory $dslAdapterFactory) {
        $this->dslAdapterFactory = $dslAdapterFactory;
    }

    public function retrieve(string $jsonFilePath) {

        if (!file_exists($jsonFilePath)) {
            throw new DSLException('The given jsonFilePath ('.$jsonFilePath.') is not a valid file path.');
        }

        $baseDirectory = explode('/', $jsonFilePath);
        array_pop($baseDirectory);

        $data = json_decode(file_get_contents($jsonFilePath), true);
        if (empty($data)) {
            throw new DSLException('The given jsonFilePath ('.$jsonFilePath.') is not a valid json file.');
        }

        $data['base_directory'] = implode('/', $baseDirectory);
        $dslAdapter = $this->dslAdapterFactory->create();
        return $dslAdapter->fromDataToDSL($data);
    }

}
