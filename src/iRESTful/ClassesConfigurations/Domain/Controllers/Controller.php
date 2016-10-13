<?php
namespace iRESTful\ClassesConfigurations\Domain\Controllers;

interface Controller {
    public function getPattern();
    public function getMethod();
    public function getControllerClass();
}
