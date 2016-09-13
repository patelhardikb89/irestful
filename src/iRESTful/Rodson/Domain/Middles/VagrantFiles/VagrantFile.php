<?php
namespace iRESTful\Rodson\Domain\Middles\VagrantFiles;

interface VagrantFile {
    public function getName();
    public function hasRelationalDatabase();
    public function getData();
}
