<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers;

interface Container {
    public function isLoopContainer();
    public function hasAnnotatedEntity();
    public function getAnnotatedEntity();
    public function hasValue();
    public function getValue();
}
