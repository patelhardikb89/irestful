<?php
namespace iRESTful\Rodson\Domain\Adapters;

interface Adapter {
    public function hasFromType();
    public function fromType();
    public function hasToType();
    public function toType();
    public function getMethod();
}
