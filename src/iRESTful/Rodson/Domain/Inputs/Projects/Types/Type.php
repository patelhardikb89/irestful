<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Types;

interface Type {
    public function getName();
    public function getDatabaseType();
    public function getDatabaseConverter();
    public function getDatabaseConverterMethodName();
    public function hasViewConverter();
    public function getViewConverter();
    public function getViewConverterMethodName();
    public function hasMethod();
    public function getMethod();
}
