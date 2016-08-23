<?php
namespace iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Converters;

interface Converter {
    public function hasDatabaseConverter();
    public function getDatabaseConverter();
    public function hasViewConverter();
    public function getViewConverter();
    public function getData();
}
