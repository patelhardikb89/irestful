<?php
namespace iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Converters\Singles;

interface SingleConverter {
    public function getInterfaceName();
    public function getMethodName();
}
