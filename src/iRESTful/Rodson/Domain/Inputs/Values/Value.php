<?php
namespace iRESTful\Rodson\Domain\Inputs\Values;

interface Value {
    public function hasInputVariable();
    public function getInputVariable();
    public function hasEnvironmentVariable();
    public function getEnvironmentVariable();
    public function hasDirect();
    public function getDirect();
}
