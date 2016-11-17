<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Objects\ConcreteUuid;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Exceptions\UuidException;

final class ConcreteUuidAdapter implements UuidAdapter {

    public function __construct() {

    }

    public function fromStringToUuid($string) {

        $fn = function($methodName, $string) {
            try {

                return $this->$methodName($string);

            } catch (UuidException $exception) {
                return null;
            }
        };

        $uuid = $fn('fromHumanReadableStringToUuid', $string);
        if (empty($uuid)) {
            $uuid = $fn('fromBinaryStringToUuid', $string);
        }

        if (empty($uuid)) {
            throw new UuidException('It was impossible to convert the given string to a Uuid object.');
        }

        return $uuid;

    }

    public function fromStringsToUuids(array $strings) {

        $uuids = [];
        foreach($strings as $oneString) {
            $uuids[] = $this->fromStringToUuid($oneString);
        }

        return $uuids;

    }

    public function fromHumanReadableStringToUuid($humanReadable) {
        return new ConcreteUuid($humanReadable);
    }

    public function fromHumanReadableStringsToUuids(array $humanReadables) {
        $output = array();
        foreach($humanReadables as $oneUuid) {
            $output[] = $this->fromHumanReadableStringToUuid($oneUuid);
        }

        return $output;
    }

    public function fromBinaryStringToUuid($binaryUuid) {
        return new ConcreteUuid(null, $binaryUuid);
    }

    public function fromBinaryStringsToUuids(array $binaryUuids) {
        $output = array();
        foreach($binaryUuids as $oneUuid) {
            $output[] = $this->fromBinaryStringToUuid($oneUuid);
        }

        return $output;
    }

    public function fromUuidsToBinaryStrings(array $uuids) {

        $output = array();
        foreach($uuids as $oneUuid) {
            $output[] = $oneUuid->get();
        }

        return $output;

    }

    public function fromUuidsToHumanReadableStrings(array $uuids) {

        $output = array();
        foreach($uuids as $oneUuid) {
            $output[] = $oneUuid->getHumanReadable();
        }

        return $output;
    }

}
