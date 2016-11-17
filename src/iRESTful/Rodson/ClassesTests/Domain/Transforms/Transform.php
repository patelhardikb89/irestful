<?php
namespace iRESTful\Rodson\ClassesTests\Domain\Transforms;

interface Transform {
    public function getNamespace();
    public function getSamples();
    public function getConfiguration();
}
