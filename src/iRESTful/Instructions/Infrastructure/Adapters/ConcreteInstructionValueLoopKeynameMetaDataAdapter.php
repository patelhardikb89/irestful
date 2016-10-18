<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Values\Loops\Keynames\MetaDatas\Adapters\MetaDataAdapter;
use iRESTful\Instructions\Domain\Values\Loops\Keynames\MetaDatas\Properties\Adapters\PropertyAdapter;
use iRESTful\Instructions\Infrastructure\Objects\ConcreteInstructionValueLoopKeynameMetaData;

final class ConcreteInstructionValueLoopKeynameMetaDataAdapter implements MetaDataAdapter {
    private $propertyAdapter;
    public function __construct(PropertyAdapter $propertyAdapter) {
        $this->propertyAdapter = $propertyAdapter;
    }

    public function fromStringToMetaData($string) {

        if ($string == 'length') {
            return new ConcreteInstructionValueLoopKeynameMetaData(true);
        }

        $exploded = explode('.', $string);
        if (isset($exploded[0]) && isset($exploded[1]) && ($exploded[0] == 'exploded')) {
            $property = $this->propertyAdapter->fromStringToProperty($exploded[1]);
            return new ConcreteInstructionValueLoopKeynameMetaData(false, $property);
        }

        //throws
    }

}
