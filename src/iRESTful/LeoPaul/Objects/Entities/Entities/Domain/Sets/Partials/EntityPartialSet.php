<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials;

interface EntityPartialSet {
    public function hasEntities();
    public function getEntities();
    public function getIndex();
    public function getAmount();
    public function getTotalAmount();
}
