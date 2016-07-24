<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Types;

interface Type {
    public function isArray();
    public function hasNamespace();
    public function getNamespace();
}
