<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Adapters;

interface Adapter {
    public function getType();
    public function getInterface();
    public function getNamespace();
    public function getConstructor();
    public function getCustomMethods();
}
