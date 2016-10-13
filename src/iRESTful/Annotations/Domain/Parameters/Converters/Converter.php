<?php
namespace iRESTful\Annotations\Domain\Parameters\Converters;

interface Converter {
    public function hasDatabaseConverter();
    public function getDatabaseConverter();
    public function hasViewConverter();
    public function getViewConverter();
}
