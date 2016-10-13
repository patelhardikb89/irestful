<?php
namespace iRESTful\DSLs\Domain\Projects\Types\Databases\Strings;

interface StringType {
    public function hasSpecificCharacterSize();
    public function getSpecificCharacterSize();
    public function hasMaxCharacterSize();
    public function getMaxCharacterSize();
    public function getData();
}
