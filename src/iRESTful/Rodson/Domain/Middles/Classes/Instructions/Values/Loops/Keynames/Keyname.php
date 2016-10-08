<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Values\Loops\Keynames;

interface Keyname {
    public function getName();
    public function hasMetaData();
    public function getMetaData();
}
