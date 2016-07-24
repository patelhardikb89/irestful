<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Repositories;
use iRESTful\Rodson\Domain\Inputs\Repositories\RodsonRepository;
use iRESTful\Rodson\Domain\Inputs\Repositories\Criterias\Adapters\RodsonRetrieverCriteriaAdapter;
use iRESTful\Rodson\Domain\Inputs\Adapters\Factories\Adapters\RodsonAdapterFactoryAdapter;
use iRESTful\Rodson\Domain\Inputs\Exceptions\RodsonException;

final class ConcreteRodsonRepository implements RodsonRepository {
    private $adapterFactoryAdapter;
    private $criteriaAdapter;
    public function __construct(RodsonAdapterFactoryAdapter $adapterFactoryAdapter, RodsonRetrieverCriteriaAdapter $criteriaAdapter) {
        $this->adapterFactoryAdapter = $adapterFactoryAdapter;
        $this->criteriaAdapter = $criteriaAdapter;
    }

    public function retrieve(array $data) {

        $criteria = $this->criteriaAdapter->fromDataToRodsonRetrieverCriteria($data);
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

        $adapter = $this->adapterFactoryAdapter->fromDataToRodsonAdapterFactory($data)->create();
        return $adapter->fromDataToRodson($data);
    }

}
