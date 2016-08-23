<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Updates;

interface Update {
    public function getSource();
    public function getUpdated();
    public function getData();
}
