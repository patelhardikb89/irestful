<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers;

interface Container {
    public function hasValue();
    public function getValue();
    public function hasAnnotatedClass();
    public function getAnnotatedClass();
}
