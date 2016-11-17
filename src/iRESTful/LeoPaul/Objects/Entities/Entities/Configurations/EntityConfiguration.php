<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Configurations;

interface EntityConfiguration {
    public function getDelimiter();
    public function getTimezone();
    public function getContainerClassMapper();
    public function getInterfaceClassMapper();
    public function getTransformerObjects();
}
