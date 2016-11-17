<?php
namespace iRESTful\Rodson\Instructions\Domain\Containers;

interface Container {
    public function isLoopContainer();
    public function hasAnnotatedEntity();
    public function getAnnotatedEntity();
    public function hasValue();
    public function getValue();
}
