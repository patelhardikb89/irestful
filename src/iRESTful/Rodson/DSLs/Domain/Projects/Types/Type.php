<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Types;

interface Type {
    public function getName();
    public function getDatabaseType();
    public function getDatabaseConverter();
    public function getDatabaseConverterFunctionName();
    public function hasViewConverter();
    public function getViewConverter();
    public function getViewConverterFunctionName();
    public function hasFunction();
    public function getFunction();
}
