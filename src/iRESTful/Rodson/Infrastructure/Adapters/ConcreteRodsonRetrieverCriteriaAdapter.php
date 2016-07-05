<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Repositories\Criterias\Adapters\RodsonRetrieverCriteriaAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteRodsonRetrieverCriteria;

final class ConcreteRodsonRetrieverCriteriaAdapter implements RodsonRetrieverCriteriaAdapter {

    public function __construct() {

    }

    public function fromDataToRodsonRetrieverCriteria(array $data) {

        $jsonFilePath = null;
        if (isset($data['file_path'])) {
            $jsonFilePath = $data['file_path'];
        }

        return new ConcreteRodsonRetrieverCriteria($jsonFilePath);

    }

}
