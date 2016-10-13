<?php
namespace iRESTful\ClassesConfigurations\Domain\Objects;

interface ObjectConfiguration {
    public function getNamespace();
    public function getDelimiter();
    public function getTimezone();
    public function getContainerClassMapper();
    public function getInterfaceClassMapper();
    public function getAdapterInterfaceClassMapper();
}
