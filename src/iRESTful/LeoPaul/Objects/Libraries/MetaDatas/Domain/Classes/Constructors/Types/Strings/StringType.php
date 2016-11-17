<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Strings;

interface StringType {
    public function hasSpecificCharacterSize();
    public function getSpecificCharacterSize();
    public function hasMaxCharacterSize();
    public function getMaxCharacterSize();
}
