<?php
namespace iRESTful\Rodson\ClassesTests\Domain\Controllers;

interface Controller {
    public function getNamespace();
    public function getConfiguration();
    public function getCustomMethodNodes();
}
