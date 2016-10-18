<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Values\Loops\Keynames\Adapters\KeynameAdapter;
use iRESTful\Instructions\Domain\Values\Loops\Keynames\MetaDatas\Adapters\MetaDataAdapter;
use iRESTful\Instructions\Infrastructure\Objects\ConcreteInstructionValueLoopKeyname;

final class ConcreteInstructionValueLoopKeynameAdapter implements KeynameAdapter {
    private $metaDataAdapter;
    public function __construct(MetaDataAdapter $metaDataAdapter) {
        $this->metaDataAdapter = $metaDataAdapter;
    }

    public function fromStringToKeyname($string) {

        $metaData = null;
        $pos = strpos($string, '|');
        if ($pos !== false) {
            $name = substr($string, 0, $pos);
            $metaDataString = substr($string, $pos + 1);
            $metaData = $this->metaDataAdapter->fromStringToMetaData($metaDataString);
            return new ConcreteInstructionValueLoopKeyname($name, $metaData);
        }

        return new ConcreteInstructionValueLoopKeyname($string);

    }

}
