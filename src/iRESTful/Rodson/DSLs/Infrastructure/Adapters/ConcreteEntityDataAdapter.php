<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Data\Adapters\EntityDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Factories\UuidFactory;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Factories\DateTimeFactory;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Data\Exceptions\EntityDataException;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteEntityData;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;

final class ConcreteEntityDataAdapter implements EntityDataAdapter {
    private $uuidFactory;
    private $dateTimeFactory;
    private $objects;
    public function __construct(UuidFactory $uuidFactory, DateTimeFactory $dateTimeFactory, array $objects) {
        $this->uuidFactory = $uuidFactory;
        $this->dateTimeFactory = $dateTimeFactory;
        $this->objects = $objects;
    }

    public function fromDataToEntityDatas(array $data) {

        $processReferences = function(array $data) {

            $getReferenceData = function(array $data, $containerName, $referenceName) {

                foreach($data[$containerName] as $oneReferenceName => $oneData) {
                    if ($oneReferenceName == $referenceName) {
                        return $oneData;
                    }
                }

                return null;

            };

            $populateReferenceData = function(Object $object, array $currentData, &$removeFromOutput = [], $parentName = null) use(&$populateReferenceData, &$getReferenceData, &$data) {

                $output = [];
                foreach($currentData as $name => $value) {

                    $output[$name] = $value;

                    if (is_array($value)) {

                        $referencedObject = $object;
                        if (is_string($name)) {
                            $referencedObject = $object->getObjectByPropertyByName($name);
                        }

                        $output[$name] = $populateReferenceData($referencedObject, $value, $removeFromOutput, $name);
                        continue;

                    }

                    if (!is_string($value)) {
                        continue;
                    }

                    if (strpos($value, '->') === 0) {
                        $value = substr($value, 2);
                        $containerName = $object->getName();

                        $removeFromOutput[] = [
                            'container' => $containerName,
                            'reference' => $value
                        ];

                        $output[$name] = $getReferenceData($data, $containerName, $value);
                        $output[$name] = $populateReferenceData($object, $output[$name], $removeFromOutput, $name);
                    }

                }

                return $output;
            };

            $reinforce = function(array $data) {
                $output = [];
                foreach($data as $container => $elements) {
                    foreach($elements as $referenceName => $oneData) {

                        $uuid = $this->uuidFactory->create();
                        $createdOn = $this->dateTimeFactory->create();
                        $output[$container][$referenceName] = array_merge($oneData, [
                            'uuid' => $uuid->getHumanReadable(),
                            'created_on' => $createdOn->getTimestamp()
                        ]);
                    }
                }

                return $output;
            };

            $output = [];
            $removeFromOutput = [];
            $data = $reinforce($data);
            foreach($data as $container => $elements) {

                if (!isset($this->objects[$container])) {
                    throw new EntityDataException('The given container ('.$container.') was referenced in the data section, but is not declared in the objects section.');
                }

                foreach($elements as $referenceName => $oneData) {
                    $output[$container][$referenceName] = $populateReferenceData($this->objects[$container], $oneData, $removeFromOutput);
                }
            }

            if (!empty($removeFromOutput)) {
                foreach($removeFromOutput as $oneRemoveFromOutput) {

                    $containerName = $oneRemoveFromOutput['container'];
                    $reference = $oneRemoveFromOutput['reference'];

                    if (isset($output[$containerName][$reference])) {
                        unset($output[$containerName][$reference]);
                    }

                    if (empty($output[$containerName])) {
                        unset($output[$containerName]);
                    }
                }
            }

            return $output;

        };

        $output = [];
        $data = $processReferences($data);
        foreach($data as $container => $elements) {
            foreach($elements as $referenceName => $oneData) {
                $output[$container][$referenceName] = new ConcreteEntityData($container, $oneData);
            }
        }

        return $output;

    }

}
