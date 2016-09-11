<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Transforms;

interface Transform {
    public function getNamespace();
    public function getSamples();
    public function getConfiguration();
    public function getData();
}
