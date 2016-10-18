<?php
namespace iRESTful\Classes\Domain\CustomMethods;

interface CustomMethod {
    public function getName();
    public function getSourceCode();
    public function hasParameters();
    public function getParameters();
}
