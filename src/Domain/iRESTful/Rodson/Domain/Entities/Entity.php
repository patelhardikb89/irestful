<?php
namespace iRESTful\Rodson\Domain\Entities;

interface Entity {
    public function getName();
    public function getProperties();
    public function getDatabase();
}
