<?php
namespace iRESTful\Annotations\Domain\Parameters\Flows;

interface Flow {
    public function getPropertyName();
    public function getMethodChain();
    public function getKeyname();
}
