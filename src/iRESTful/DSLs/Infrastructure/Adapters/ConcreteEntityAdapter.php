<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Entities\Adapters\EntityAdapter;
use iRESTful\DSLs\Domain\Projects\Objects\Entities\Samples\Nodes\Adapters\SampleNodeAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteEntity;
use iRESTful\DSLs\Domain\Projects\Objects\Entities\Exceptions\EntityException;

final class ConcreteEntityAdapter implements EntityAdapter {
    private $sampleNodeAdapter;
    public function __construct(SampleNodeAdapter $sampleNodeAdapter) {
        $this->sampleNodeAdapter = $sampleNodeAdapter;
    }

    public function fromDataToEntities(array $data) {

        if (!isset($data['objects'])) {
            throw new EntityException('The objects keyname is mandatory in order to convert data to Entity objects.');
        }

        if (!isset($data['samples'])) {
            throw new EntityException('The samples keyname is mandatory in order to convert data to Entity objects.');
        }

        $output = [];
        $sampleNode = $this->sampleNodeAdapter->fromDataToSampleNode($data['samples']);
        foreach($data['objects'] as $keyname => $oneObject) {

            if (!$oneObject->hasDatabase()) {
                continue;
            }

            if (!$sampleNode->hasSampleByName($keyname)) {
                throw new EntityException('The object ('.$keyname.') does not have a sample, but contain a database.');
            }

            $sample = $sampleNode->getSampleByName($keyname);
            $output[$keyname] = $this->fromDataToEntity([
                'object' => $oneObject,
                'sample' => $sample
            ]);
        }

        return $output;
    }

    public function fromDataToEntity(array $data) {

        if (!isset($data['object'])) {
            throw new EntityException('The object keyname is mandatory in order to convert data to an Entity object.');
        }

        if (!isset($data['sample'])) {
            throw new EntityException('The sample keyname is mandatory in order to convert data to an Entity object.');
        }

        return new ConcreteEntity($data['object'], $data['sample']);

    }

}
