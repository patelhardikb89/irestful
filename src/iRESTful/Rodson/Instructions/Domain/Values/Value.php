<?php
namespace iRESTful\Rodson\Instructions\Domain\Values;

interface Value {
    public function hasLoop();
    public function getLoop();
    public function hasValue();
    public function getValue();
}
