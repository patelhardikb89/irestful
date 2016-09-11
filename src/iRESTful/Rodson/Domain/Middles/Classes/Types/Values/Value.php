<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Values;

interface Value {
    public function getType();
    public function getNamespace();
    public function getInterface();
    public function getConstructor();
    public function getAdapter();
    public function hasCustomMethod();
    public function getCustomMethod();
    public function getData();
}
