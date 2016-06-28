<?php
namespace iRESTful\Rodson\Domain\Controllers;

interface Controller {
    public function getPattern();
    public function getInstructions();
    public function getView();
}
