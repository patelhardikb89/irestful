<?php
namespace iRESTful\Rodson\Instructions\Domain\Values\Loops\Keynames;

interface Keyname {
    public function getName();
    public function hasMetaData();
    public function getMetaData();
}
