<?php
namespace iRESTful\Rodson\Domain\Inputs\Types\Databases\Strings;

interface String {
    public function hasSpecificCharacterSize();
    public function getSpecificCharacterSize();
    public function hasMaxCharacterSize();
    public function getMaxCharacterSize();
}
