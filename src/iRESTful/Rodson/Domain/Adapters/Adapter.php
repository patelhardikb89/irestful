<?php
namespace iRESTful\Rodson\Domain\Adapters;

interface Adapter {
    public function fromType();
    public function toType();
    public function getMethod();
}
