<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Values;

interface Value {
    public function hasLoop();
    public function getLoop();
    public function hasValue();
    public function getValue();
}
