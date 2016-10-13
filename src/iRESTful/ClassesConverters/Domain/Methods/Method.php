<?php
namespace iRESTful\ClassesConverters\Domain\Methods;

interface Method {
    public function getName();
    public function getParameter();
    public function getNamespace();
}
