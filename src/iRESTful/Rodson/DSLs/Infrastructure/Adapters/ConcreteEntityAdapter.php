<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Adapters\EntityAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Samples\Nodes\Adapters\SampleNodeAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteEntity;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Exceptions\EntityException;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Data\Adapters\EntityDataAdapter;

final class ConcreteEntityAdapter implements EntityAdapter {
    private $sampleNodeAdapter;
    private $entityDataAdapter;
    public function __construct(SampleNodeAdapter $sampleNodeAdapter, EntityDataAdapter $entityDataAdapter) {
        $this->sampleNodeAdapter = $sampleNodeAdapter;
        $this->entityDataAdapter = $entityDataAdapter;
    }

    public function fromDataToEntities(array $data) {

        if (!isset($data['objects'])) {
            throw new EntityException('The objects keyname is mandatory in order to convert data to Entity objects.');
        }

        if (!isset($data['samples'])) {
            throw new EntityException('The samples keyname is mandatory in order to convert data to Entity objects.');
        }

        $entityDatas = null;
        if (isset($data['data'])) {
            $entityDatas = $this->entityDataAdapter->fromDataToEntityDatas($data['data']);
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
                'sample' => $sample,
                'entity_datas' => (isset($entityDatas[$keyname])) ? $entityDatas[$keyname] : null
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

        $entityDatas = null;
        if (isset($data['entity_datas'])) {
            $entityDatas = $data['entity_datas'];
        }

        return new ConcreteEntity($data['object'], $data['sample'], $entityDatas);

    }

}
