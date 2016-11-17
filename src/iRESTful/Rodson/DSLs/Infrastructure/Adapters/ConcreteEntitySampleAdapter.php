<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Samples\Adapters\SampleAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Factories\UuidFactory;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Factories\DateTimeFactory;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\MetaDatas\Adapters\ObjectMetaDataAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteEntitySample;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Samples\Exceptions\SampleException;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Samples\References\Adapters\ReferenceAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Samples\Sample;

final class ConcreteEntitySampleAdapter implements SampleAdapter {
    private $objects;
    private $uuidFactory;
    private $dateTimeFactory;
    private $referenceAdapter;
    public function __construct(UuidFactory $uuidFactory, DateTimeFactory $dateTimeFactory, ReferenceAdapter $referenceAdapter, array $objects) {
        $this->objects = $objects;
        $this->uuidFactory = $uuidFactory;
        $this->dateTimeFactory = $dateTimeFactory;
        $this->referenceAdapter = $referenceAdapter;
    }

    public function fromSampleToData(Sample $sample) {

        $getReferenceSamples = function() use(&$sample) {
            $output = [];
            if (!$sample->hasReferences()) {
                return $output;
            }

            $references = $sample->getReferences();
            foreach($references as $oneReference) {

                $referencedSample = $oneReference->getSample();
                $referencedSamplesData = $this->fromSampleToData($referencedSample);

                $property = $oneReference->getProperty();
                $isOptional = $property->isOptional();

                $propertyType = $property->getType();
                $keyname = $property->getName();
                $isArray = $propertyType->isArray();

                $output[$keyname] = [];
                if ($isArray) {

                    if ($isOptional) {
                        $output[$keyname][] = null;
                    }

                    $output[$keyname][] = array_merge($referencedSamplesData, $output[$keyname]);
                }

                if (!$isArray) {
                    if ($isOptional) {
                        $output[$keyname][] = null;
                    }

                    foreach($referencedSamplesData as $oneSample) {
                        $output[$keyname][] = $oneSample;
                    }
                }
            }

            return $output;
        };

        $getNormalizedReferenceSamples = function() use(&$sample) {
            $output = [];
            if (!$sample->hasNormalizedReferences()) {
                return $output;
            }

            $normalized = [];
            $normalizedReferences = $sample->getNormalizedReferences();
            foreach($normalizedReferences as $name => $oneData) {
                $index = mt_rand(0, count($oneData) - 1);
                foreach($oneData as $index => $oneSubData) {
                    foreach($oneSubData as $subName => $oneElement) {
                        $keyname = $name.'___'.$subName;
                        $normalized[$index][$keyname] = $oneElement;
                    }
                }

            }

            return $normalized;
        };

        $generateOutput = function(array $referenceSamples, array $additions) use(&$sample) {

            $getBase = function() {
                return [
                    'uuid' => $this->uuidFactory->create()->getHumanReadable(),
                    'created_on' => $this->dateTimeFactory->create()->getTimestamp()
                ];
            };

            $getBiggestAmount = function(array $data) {
                $amount = 0;
                foreach($data as $oneData) {
                    $dataAmount = count($oneData);
                    if ($dataAmount > $amount) {
                        $amount = $dataAmount;
                    }
                }

                return $amount;

            };

            $mergeReferenceSamples = function(array $referenceSamples) use(&$getBiggestAmount) {
                $output = [];
                $keynames = array_keys($referenceSamples);
                $biggestIndex = $getBiggestAmount($referenceSamples);
                for($i = 0; $i < $biggestIndex; $i++) {

                    $currentOutput = [];
                    foreach($keynames as $oneKeyname) {

                        $currentIndex = $i;
                        if (!array_key_exists($currentIndex, $referenceSamples[$oneKeyname])) {
                            $currentIndex = mt_rand(0, count($referenceSamples[$oneKeyname]) - 1);
                        }

                        if (is_array($referenceSamples[$oneKeyname][$currentIndex])) {
                            $referenceSamples[$oneKeyname][$currentIndex] = array_filter($referenceSamples[$oneKeyname][$currentIndex], function($value, $keyname) {

                                if (is_int($keyname) && empty($value)) {
                                    return false;
                                }

                                return true;

                            }, \ARRAY_FILTER_USE_BOTH);
                        }

                        $currentOutput = array_merge($currentOutput, [
                            $oneKeyname => $referenceSamples[$oneKeyname][$currentIndex]
                        ]);
                    }

                    $output[$i] = $currentOutput;

                }

                return $output;
            };

            $mergeAdditions = function(array $additions) {
                $output = [];
                foreach($additions as $oneAddition) {
                    $output[] = $oneAddition;
                }

                return $output;
            };

            $merge = function(array $additions, array $referenceSamples) {

                $additionsCount = count($additions);
                $referenceSamplesCount = count($referenceSamples);
                $biggestAmount = ($additionsCount < $referenceSamplesCount) ? $referenceSamplesCount : $additionsCount;

                $output = [];
                for($i = 0; $i < $biggestAmount; $i++) {

                    $additionsCurrentIndex = $i;
                    if (!array_key_exists($additionsCurrentIndex, $additions)) {
                        $additionsCurrentIndex = mt_rand(0, count($additions) - 1);
                    }

                    $referenceSamplesIndex = $i;
                    if (!array_key_exists($referenceSamplesIndex, $referenceSamples)) {
                        $referenceSamplesIndex = mt_rand(0, count($referenceSamples) - 1);
                    }

                    $output[] = array_merge($additions[$additionsCurrentIndex], $referenceSamples[$referenceSamplesIndex]);
                }

                return $output;

            };

            $addBase = function(array $data) use(&$getBase) {
                foreach($data as $index => $oneData) {
                    $data[$index] = array_merge($getBase(), $oneData);
                }

                return $data;
            };

            if (empty($referenceSamples) && empty($additions)) {
                throw new SampleException('The sample has no reference, normalized samples or additions.');
            }

            if (empty($referenceSamples)) {
                $merged = $mergeAdditions($additions);
                return $addBase($merged);
            }

            if (empty($additions)) {
                $merged = $mergeReferenceSamples($referenceSamples);
                return $addBase($merged);
            }

            $mergedAdditions = $mergeAdditions($additions);
            $mergedReferenceSamples = $mergeReferenceSamples($referenceSamples);
            $merged = $merge($mergedAdditions, $mergedReferenceSamples);
            return $addBase($merged);

        };

        $generateAllAdditions = function(array $normalizedSamples, array $additions) {

            if (empty($additions)) {
                return $normalizedSamples;
            }

            if (empty($normalizedSamples)) {
                return $additions;
            }

            $totalAdditions = [];
            foreach($additions as $oneAdditionData) {
                foreach($normalizedSamples as $oneNormalizedSamplesData) {
                    $totalAdditions[] = array_merge($oneAdditionData, $oneNormalizedSamplesData);
                }
            }

            return $totalAdditions;

        };

        $referenceSamples = $getReferenceSamples();
        $normalizedSamples = $getNormalizedReferenceSamples();
        $additions = ($sample->hasAdditions()) ? $sample->getAdditions() : [];
        $totalAdditions = $generateAllAdditions($normalizedSamples, $additions);

        return $generateOutput($referenceSamples, $totalAdditions);
    }

    public function fromDataToSamples(array $data) {

        $getEmptySamples = function(array $objects, array $samples) {
            $output = [];
            $keynames = array_keys($objects);
            foreach($keynames as $oneKeyname) {
                if (isset($samples[$oneKeyname])) {
                    continue;
                }

                $output[$oneKeyname] = [];
            }

            return $output;
        };

        $getObjectProperties = function(Object $object) {

            $references = [];
            $properties = $object->getProperties();
            foreach($properties as $oneProperty) {

                $type = $oneProperty->getType();
                if ($type->hasObject() || $type->hasParentObject()) {
                    $references[] = $oneProperty;
                }
            }

            return $references;
        };

        $getReferences = function(array $objectProperties) {

            $output = [];
            foreach($objectProperties as $oneProperty) {
                $type = $oneProperty->getType();
                if ($type->hasObject()) {
                    $object = $oneProperty->getType()->getObject();
                    if ($object->hasDatabase()) {
                        $output[] = $oneProperty;
                        continue;
                    }
                }
            }

            return $output;

        };

        $getParentReferences = function(array $objectProperties) {
            $output = [];
            foreach($objectProperties as $oneProperty) {
                $type = $oneProperty->getType();
                if ($type->hasParentObject()) {
                    $parentObject = $type->getParentObject();
                    $objectName = $parentObject->getObject()->getName();

                    $project = $parentObject->getSubDSL()->getDSL()->getProject();
                    if ($project->hasEntityByName($objectName)) {
                        $output[] = $oneProperty;//$project->getEntityByName($objectName);
                    }
                }
            }

            return $output;
        };

        $getNormalizedReferences = function(array $samples, array $objectProperties) {

            $getNormalizedProperties = function(array $properties) {

                $output = [];
                foreach($properties as $oneProperty) {
                    $type = $oneProperty->getType();
                    if ($type->hasObject()) {
                        if (!$type->getObject()->hasDatabase()) {
                            $output[] = $oneProperty;
                        }
                    }

                }

                return $output;

            };

            $getReferencedSamples = function(array $referencedProperties, array $samples) {

                $getSamplesByName = function($name) use(&$samples) {
                    foreach($samples as $keyname => $oneSamples) {

                        if ($name === $keyname) {
                            return $oneSamples;
                        }
                    }

                    return null;
                };

                $output = [];
                foreach($referencedProperties as $oneReferencedProperty) {

                    $referencedPropertyName = $oneReferencedProperty->getName();
                    $referencedPropertyType = $oneReferencedProperty->getType();

                    $referencedName = $referencedPropertyType->getObject()->getName();
                    $output[$referencedPropertyName] =  $getSamplesByName($referencedName);

                }

                return $output;

            };

            $normalizedProperties = $getNormalizedProperties($objectProperties);
            if (empty($normalizedProperties)) {
                return [];
            }

            return $getReferencedSamples($normalizedProperties, $samples);
        };

        $generate = function(array $samplesInput, array $totalSamples = [], &$output = []) use(&$generate, &$getEmptySamples, &$getObjectProperties, &$getNormalizedReferences, &$getReferences, &$getParentReferences) {

            $hasAllReferences = function(array $output, array $references) {

                foreach($references as $oneReference) {
                    $type = $oneReference->getType();
                    if ($type->hasObject()) {
                        $name = $type->getObject()->getName();
                        if (!isset($output[$name])) {
                            return false;
                        }
                    }

                }

                return true;

            };

            $incompleteSamples = [];
            if (empty($totalSamples)) {
                $emptySamples = $getEmptySamples($this->objects, $samplesInput);
                $totalSamples = array_merge($samplesInput, $emptySamples);
                $samplesInput = $totalSamples;
            }

            foreach($samplesInput as $name => $additions) {

                if (!isset($this->objects[$name])) {
                    //throws
                }

                if (!$this->objects[$name]->hasDatabase()) {
                    continue;
                }

                $objectProperties = $getObjectProperties($this->objects[$name]);
                $referencedProperties = $getReferences($objectProperties);
                $normalizedReferences = $getNormalizedReferences($totalSamples, $objectProperties);
                $parentReferences = $getParentReferences($objectProperties);

                if (!$hasAllReferences($output, $referencedProperties)) {
                    $incompleteSamples[$name] = $additions;
                    continue;
                }

                $references = $this->referenceAdapter->fromDataToReferences([
                    'samples' => $output,
                    'properties' => array_merge($referencedProperties, $parentReferences)
                ]);

                $output[$name] = new ConcreteEntitySample($name, $additions, $references, $normalizedReferences);

            }

            if (!empty($incompleteSamples)) {

                if (count($samplesInput) == count($incompleteSamples)) {
                    $incomplete = implode(', ', array_keys($incompleteSamples));
                    $successful = implode(', ', array_keys($output));
                    throw new SampleException('Some samples cannot be generated because they have invalid references.  We have been able to create these samples: '.$successful.'.  While these failed: '.$incomplete);
                }

                return $generate($incompleteSamples, $totalSamples, $output);
            }

            return $output;
        };

        return $generate($data);

    }

}
