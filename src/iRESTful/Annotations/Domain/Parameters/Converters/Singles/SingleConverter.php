<?php
namespace iRESTful\Annotations\Domain\Parameters\Converters\Singles;

interface SingleConverter {
    public function getInterfaceName();
    public function getMethodName();
}
