<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Repositories\Criterias\Adapters\RodsonRetrieverCriteriaAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteRodsonRetrieverCriteria;
use iRESTful\Rodson\Domain\Inputs\Repositories\Criterias\Exceptions\RodsonRetrieverCriteriaException;

final class ConcreteRodsonRetrieverCriteriaAdapter implements RodsonRetrieverCriteriaAdapter {

    public function __construct() {

    }

    public function fromFilePathToRodsonRetrieverCriteria($filePath) {

        if (!file_exists($filePath)) {
            throw new RodsonRetrieverCriteriaException('The given filePath ('.$filePath.') does not exists.');
        }

        return new ConcreteRodsonRetrieverCriteria($filePath);
    }

}
