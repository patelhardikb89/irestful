<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Repositories\Criterias\Adapters\RodsonRetrieverCriteriaAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteRodsonRetrieverCriteria;

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
