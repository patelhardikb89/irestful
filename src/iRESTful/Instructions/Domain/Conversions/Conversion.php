<?php
namespace iRESTful\Instructions\Domain\Conversions;

interface Conversion {
    public function from();
    public function to();
}
