<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects;

final class BigProperty {
    private $title;
    private $isGood;

    /**
    *   @title -> getTitle() -> title ## @string specific -> 255
    *   @isGood -> isGood() -> is_good ## @boolean
    */
    public function __construct($title, $isGood = false) {
        $this->title = $title;
        $this->isGood = $isGood;
    }

    public function getTitle() {
        return $this->title;
    }

    public function isGood() {
        return $this->isGood;
    }

}
