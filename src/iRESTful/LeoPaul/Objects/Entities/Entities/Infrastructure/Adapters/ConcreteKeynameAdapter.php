<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Adapters\KeynameAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Exceptions\KeynameException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\ConcreteKeyname;

final class ConcreteKeynameAdapter implements KeynameAdapter {

    public function __construct() {

    }

    public function fromDataToKeyname(array $data) {

        if (!isset($data['name'])) {
            throw new KeynameException('The name index is mandatory in order to convert data to a Keyname object.');
        }

        if (!isset($data['value'])) {
            throw new KeynameException('The value index is mandatory in order to convert data to a Keyname object.');
        }

        return new ConcreteKeyname($data['name'], $data['value']);

    }

    public function fromDataToKeynames(array $data) {
        $output = [];
        foreach($data as $oneData) {
            $output[] = $this->fromDataToKeyname($oneData);
        }

        return $output;
    }

}
