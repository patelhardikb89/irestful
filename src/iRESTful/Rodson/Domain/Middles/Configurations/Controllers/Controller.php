<?php
namespace iRESTful\Rodson\Domain\Middles\Configurations\Controllers;

interface Controller {
    public function getPattern();
    public function getMethod();
    public function getControllerClass();
    public function getData();
}
