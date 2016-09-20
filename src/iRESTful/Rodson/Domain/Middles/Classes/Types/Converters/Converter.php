<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Converters;

interface Converter {
    public function getType();
    public function getInterface();
    public function getNamespace();
    public function getConstructor();
    public function getMethods();
}
