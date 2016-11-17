<?php
namespace iRESTful\Rodson\Instructions\Domain\Conversions;

interface Conversion {
    public function from();
    public function to();
}
