<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs;

interface CustomMethod {
    public function getName();
    public function hasSourceCodeLines();
    public function getSourceCodeLines();
    public function hasParameters();
    public function getParameters();
}
