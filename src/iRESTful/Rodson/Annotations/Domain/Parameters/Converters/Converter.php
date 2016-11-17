<?php
namespace iRESTful\Rodson\Annotations\Domain\Parameters\Converters;

interface Converter {
    public function hasDatabaseConverter();
    public function getDatabaseConverter();
    public function hasViewConverter();
    public function getViewConverter();
}
