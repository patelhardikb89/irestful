<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions;

interface Action {
    public function hasInsert();
    public function getInsert();
    public function hasUpdate();
    public function getUpdate();
    public function hasDelete();
    public function getDelete();
}
