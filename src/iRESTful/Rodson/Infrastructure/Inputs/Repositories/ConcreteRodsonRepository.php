<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Repositories;
use iRESTful\Rodson\Domain\Inputs\Repositories\RodsonRepository;
use iRESTful\Rodson\Domain\Inputs\Repositories\Criterias\Adapters\RodsonRetrieverCriteriaAdapter;
use iRESTful\Rodson\Domain\Inputs\Adapters\RodsonAdapter;
use iRESTful\Rodson\Domain\Inputs\Exceptions\RodsonException;

final class ConcreteRodsonRepository implements RodsonRepository {
    private $adapter;
    private $criteriaAdapter;
    public function __construct(RodsonAdapter $adapter, RodsonRetrieverCriteriaAdapter $criteriaAdapter) {
        $this->adapter = $adapter;
        $this->criteriaAdapter = $criteriaAdapter;
    }

    public function retrieve($filePath) {

        $criteria = $this->criteriaAdapter->fromFilePathToRodsonRetrieverCriteria($filePath);
        if (!$criteria->hasFilePath()) {
            throw new RodsonException('The RodsonRetrieverCriteria does not contain any valid retrieval criteria.');
        }

        $filePath = $criteria->getFilePath();
        $content = @file_get_contents($filePath);
        if (empty($content)) {
            throw new RodsonException('The given filePath ('.$filePath.') does not contain any valid content.');
        }

        $data = @json_decode($content, true);
        if (empty($data)) {
            throw new RodsonException('The given filePath ('.$filePath.') is not a valid json document.');
        }

        $parts = explode('/', $filePath);
        array_pop($parts);
        $data['base_directory'] = implode('/', $parts);
        return $this->adapter->fromDataToRodson($data);
    }

}
