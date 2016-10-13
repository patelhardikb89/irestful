<?php
namespace iRESTful\Authenticated\Domain\Entities;
use iRESTful\Objects\Entities\Entities\Domain\Entity;

interface Endpoint extends Entity {
    public function getPattern();
    public function getIs_user_mandatory();
    public function getParams();
    public function has_method($current, array $first, $second = null);
}

