<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Exceptions\UuidException;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;

final class ConcreteUuid implements Uuid {
    private $humanReadableUuid;
    private $uuid;
    public function __construct($humanReadableUuid = null, $uuid = null) {

        $amount = (is_null($humanReadableUuid) ? 0 : 1) + (is_null($uuid) ? 0 : 1);
        if ($amount != 1) {
            throw new UuidException('The humanReadableUuid or the uuid is mandatory.  '.$amount.' given.');
        }

        if (!is_null($uuid)) {
            $humanReadableUuid = $this->uuidToHumanReadableUuid($uuid);
        }

        if (!is_null($humanReadableUuid)) {

            if (!$this->isValid($humanReadableUuid)) {
                throw new UuidException('The givem humanReadableUuid ('.$humanReadableUuid.') is invalid.');
            }

            $uuid = hex2bin(str_replace('-', '', $humanReadableUuid));
        }

        $this->humanReadableUuid = $humanReadableUuid;
        $this->uuid = $uuid;
    }

    public function get() {
        return $this->uuid;
    }

    public function getHumanReadable() {
        return $this->humanReadableUuid;
    }

    private function isValid($humanReadableUuid) {

        $matches = array();
        preg_match_all('/[a-zA-Z0-9]{8}\-[a-zA-Z0-9]{4}\-[a-zA-Z0-9]{4}\-[a-zA-Z0-9]{4}\-[a-zA-Z0-9]{12}/s', $humanReadableUuid, $matches);

        if (isset($matches[0][0]) && ($matches[0][0] == $humanReadableUuid)) {
            return true;
        }

        return false;
    }

    private function uuidToHumanReadableUuid($uuid) {

        $uuid = strtolower(bin2hex($uuid));

        $matches = array();
        preg_match_all('/([a-z0-9]{8})([a-z0-9]{4})([a-z0-9]{4})([a-z0-9]{4})([a-z0-9]{12})/s', $uuid, $matches);
        if (!isset($matches[0][0]) || ($matches[0][0] != $uuid)) {
            throw new UuidException('The given uuid is invalid.  It must be a representation of a uuid without dashes.');
        }

        $uuidWithDashes = array();
        unset($matches[0]);
        foreach($matches as $oneData) {
            $uuidWithDashes[] = $oneData[0];
        }

        return implode('-', $uuidWithDashes);
    }

}
