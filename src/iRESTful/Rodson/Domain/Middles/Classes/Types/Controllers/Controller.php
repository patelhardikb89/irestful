<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Controllers;

interface Controller {
    public function getNamespace();
    public function getConstructor();
    public function getCustomMethod();
    public function getData();
}
