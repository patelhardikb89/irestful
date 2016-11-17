<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters;

interface UuidAdapter {
    public function fromStringToUuid($string);
    public function fromStringsToUuids(array $strings);
    public function fromHumanReadableStringToUuid($humanReadable);
    public function fromHumanReadableStringsToUuids(array $humanReadables);
    public function fromBinaryStringToUuid($binaryUuid);
    public function fromBinaryStringsToUuids(array $binaryUuids);
    public function fromUuidsToBinaryStrings(array $uuids);
    public function fromUuidsToHumanReadableStrings(array $uuids);
}
