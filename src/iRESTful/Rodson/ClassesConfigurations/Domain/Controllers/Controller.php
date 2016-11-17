<?php
namespace iRESTful\Rodson\ClassesConfigurations\Domain\Controllers;

interface Controller {
    public function getPattern();
    public function getMethod();
    public function getControllerClass();
}
