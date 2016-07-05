<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Repositories\Criterias\RodsonRetrieverCriteria;
use iRESTful\Rodson\Domain\Repositories\Criterias\Exceptions\RodsonRetrieverCriteriaException;

final class ConcreteRodsonRetrieverCriteria implements RodsonRetrieverCriteria {
    private $filePath;
    public function __construct($filePath = null) {

        if (empty($filePath)) {
            $filePath = null;
        }

        $amount = (empty($filePath) ? 0 : 1);
        if ($amount != 1) {
            throw new RodsonRetrieverCriteriaException('There must be 1 retriever criteria.  '.$amount.' given.');
        }

        if (!empty($filePath)) {

            if (!is_string($filePath)) {
                throw new RodsonRetrieverCriteriaException('The filePath must be a string if non-empty.');
            }

            if (!file_exists($filePath)) {
                throw new RodsonRetrieverCriteriaException('The given filePath ('.$filePath.') must be a valid physical file if non-empty.');
            }
        }

        $this->filePath = $filePath;

    }

    public function hasFilePath() {
        return !empty($this->filePath);
    }

    public function getFilePath() {
        return $this->filePath;
    }

}
